<?php
// Clasa pentru completarea automată a checkout-ului - class-autocomplete-checkout.php
class Autocomplete_Checkout {
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_autocomplete_script'));
    }

    public function enqueue_autocomplete_script() {
        if (is_checkout()) {
            $selected_module = get_option('facturare_anaf_module');
            $nonce = wp_create_nonce('wp_rest');
            $rest_api_url = get_rest_url(null, 'anaf/cui');

            $scripts = array(
                'smartbill' => 'autocomplete-smartbill.js',
                'facturare_woo_avian' => 'autocomplete-facturare-woo-avian.js',
                'romanian_billing_fields' => 'autocomplete-romanian-billing-fields.js'
            );

            if (array_key_exists($selected_module, $scripts)) {
                $script_handle = 'autocomplete-' . str_replace('_', '-', $selected_module);
                $script_path = plugin_dir_url(__FILE__) . '../assets/js/' . $scripts[$selected_module];
                
                wp_register_script($script_handle, $script_path, array('jquery'), '1.0.0', true);
                wp_localize_script($script_handle, 'anafApiData', array(
                    'restApiUrl' => $rest_api_url,
                    'nonce' => $nonce,
                ));
                wp_enqueue_script($script_handle);
            }
        }
    }
}

new Autocomplete_Checkout();
