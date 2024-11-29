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


// Include fișierele necesare
require_once FACTURARE_ANAF_PLUGIN_DIR . 'admin/class-settings.php';
require_once FACTURARE_ANAF_PLUGIN_DIR . 'includes/class-anaf-api.php';
require_once FACTURARE_ANAF_PLUGIN_DIR . 'includes/class-autocomplete-checkout.php';

