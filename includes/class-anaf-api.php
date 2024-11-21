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
        // if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        //     return new WP_REST_Response(['message' => __('The nonce is invalid.', 'send-data')]);
        // }

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

        $cui = $_GET['cui'];
        $data = date("Y-m-d");
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://webservicesp.anaf.ro/PlatitorTvaRest/api/' . ANAF_API_VERSION . '/ws/tva',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '[{"cui": "' . $cui . '", "data": "' . $data . '"}]',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $rsp = json_decode($response);
        // Verificăm dacă răspunsul conține pagina de mentenanță
        if (strpos($response, '<title>Mentenanta sistem</title>') !== false) {
            return new WP_REST_Response(['message' => __('Serviciul ANAF este momentan în mentenanță. Încercați din nou mai târziu.', 'send-data')]);
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