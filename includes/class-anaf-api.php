<?php
// Clasa pentru interacțiunea cu ANAF API
class ANAF_API {
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }

    public function register_routes() {
        register_rest_route('anaf', '/cui', [
            'methods' => WP_REST_Server::READABLE,
            'callback' => array($this, 'get_company_data'),
            'permission_callback' => '__return_true',
        ]);
    }

    public function get_company_data(WP_REST_Request $request) {
        if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
            return new WP_REST_Response(['message' => __('The nonce is invalid.', 'facturare-anaf-by-mihai')]);
        }

        static $lastRequest;
        $maxRequestsPerMin = 20;
        if (isset($lastRequest)) {
            $delay = 10 / $maxRequestsPerMin;
            if ((microtime(true) - $lastRequest) < $delay) {
                $sleepAmount = ($delay - microtime(true) + $lastRequest) * (1000 ** 2);
                usleep($sleepAmount);
            }
        }
        $lastRequest = microtime(true);

        $cui = isset($_GET['cui']) ? sanitize_text_field(wp_unslash($_GET['cui'])) : '';
        if (empty($cui)) {
            return new WP_REST_Response(['message' => __('CUI-ul este invalid sau lipsă.', 'facturare-anaf-by-mihai')]);
        }

        $data = gmdate("Y-m-d");
        
        $response = wp_remote_post('https://webservicesp.anaf.ro/PlatitorTvaRest/api/' . ANAF_API_VERSION . '/ws/tva', array(
            'body'    => wp_json_encode(array(array('cui' => $cui, 'data' => $data))),
            'headers' => array(
                'Content-Type' => 'application/json'
            ),
            'timeout' => 10
        ));

        if (is_wp_error($response)) {
            return new WP_REST_Response(['message' => __('Eroare la conectarea la API-ul ANAF.', 'facturare-anaf-by-mihai')]);
        }

        $body = wp_remote_retrieve_body($response);
        $rsp = json_decode($body);

        // Verificăm dacă răspunsul conține pagina de mentenanță
        if (strpos($body, '<title>Mentenanta sistem</title>') !== false) {
            return new WP_REST_Response(['message' => __('Serviciul ANAF este momentan în mentenanță. Încercați din nou mai târziu.', 'facturare-anaf-by-mihai')]);
        }

        if (empty($rsp->found)) {
            return new WP_REST_Response(false);
        } else {
            $company_data = [
                'nume' => $rsp->found[0]->date_generale->denumire,
                'reg_com' => $rsp->found[0]->date_generale->nrRegCom,
                'telefon' => $rsp->found[0]->date_generale->telefon,
                'strada' => $rsp->found[0]->adresa_sediu_social->sdenumire_Strada,
                'numar' => $rsp->found[0]->adresa_sediu_social->snumar_Strada,
                'cod_postal' => $rsp->found[0]->adresa_sediu_social->scod_Postal,
            ];
            return new WP_REST_Response($company_data);
        }
    }
}

new ANAF_API();
