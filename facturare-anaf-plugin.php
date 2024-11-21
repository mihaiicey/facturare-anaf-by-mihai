<?php
/*
Plugin Name: Facturare ANAF Plugin
Description: Plugin pentru descărcarea datelor de facturare din baza de date ANAF și completarea automată în funcție de CUI.
Version: 1.0.0
Author: Mihai Ciufudean
* Author URI: https://mihaidev.ro
License: GPL2
*/

// Definire constante
define('FACTURARE_ANAF_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Definim versiunea API ANAF în fișierul principal
define('ANAF_API_VERSION', 'v8');

// Funcția de activare a pluginului

// function facturare_anaf_activate() {
//     // Cod pentru acțiuni la activare
// }
// register_activation_hook(__FILE__, 'facturare_anaf_activate');

// Funcția de dezactivare a pluginului
// function facturare_anaf_deactivate() {
//     // Cod pentru acțiuni la dezactivare
// }
// register_deactivation_hook(__FILE__, 'facturare_anaf_deactivate');

// Încărcarea scripturilor necesare
function facturare_anaf_enqueue_scripts() {
    // nu e necesar momentan - pt viitoare dezvoltari
    // wp_enqueue_style('facturare-anaf-styles', plugins_url('assets/css/styles.css', __FILE__));
    
    // Verificăm ce modul de facturare a fost selectat și încărcăm JS-ul corespunzător
    $selected_module = get_option('facturare_anaf_module'); // Aici vom folosi o setare din admin
    if ($selected_module == 'smartbill') {
        wp_enqueue_script('autocomplete-smartbill', plugins_url('assets/js/autocomplete-smartbill.js', __FILE__), array('jquery'), null, true);
    } elseif ($selected_module == 'facturare_woo_avian') {
        wp_enqueue_script('autocomplete-facturare-woo-avian', plugins_url('assets/js/autocomplete-facturare-woo-avian.js', __FILE__), array('jquery'), null, true);
    } elseif ($selected_module == 'romanian_billing_fields') {
        wp_enqueue_script('autocomplete-romanian-billing-fields', plugins_url('assets/js/autocomplete-romanian-billing-fields.js', __FILE__), array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'facturare_anaf_enqueue_scripts');

// Include fișierele necesare
require_once FACTURARE_ANAF_PLUGIN_DIR . 'admin/class-settings.php';
require_once FACTURARE_ANAF_PLUGIN_DIR . 'includes/class-anaf-api.php';
require_once FACTURARE_ANAF_PLUGIN_DIR . 'includes/class-autocomplete-checkout.php';

