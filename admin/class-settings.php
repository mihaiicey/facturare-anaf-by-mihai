<?php
class Admin_Settings_Page {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'settings_init'));
    }

    public function add_admin_menu() {
        // Adăugăm pagina de setări în cadrul meniului Settings din admin
        add_options_page(
            'Facturare ANAF Settings',
            'Facturare ANAF',
            'manage_options',
            'facturare_anaf_settings',
            array($this, 'settings_page')
        );
    }

    public function settings_init() {
        register_setting('facturare_anaf_settings_group', 'facturare_anaf_module');

        add_settings_section(
            'facturare_anaf_settings_section',
            __('Selectați modulul de facturare', 'facturare-anaf-by-mihai'),
            null,
            'facturare_anaf_settings'
        );

        add_settings_field(
            'facturare_anaf_module_field',
            __('Modul de facturare', 'facturare-anaf-by-mihai'),
            array($this, 'render_module_field'),
            'facturare_anaf_settings',
            'facturare_anaf_settings_section'
        );
    }

    public function render_module_field() {
        $options = get_option('facturare_anaf_module');
        ?>
        <select name="facturare_anaf_module">
            <option value="" <?php selected($options, ''); ?>>Selectați un modul</option>
            <option value="smartbill" <?php selected($options, 'smartbill'); ?>>SmartBill</option>
            <option value="facturare_woo_avian" <?php selected($options, 'facturare_woo_avian'); ?>>Facturare Woo by Avian Studio</option>
            <option value="romanian_billing_fields" <?php selected($options, 'romanian_billing_fields'); ?>>Romanian Billing Fields by Robert G</option>
        </select>
        <?php
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Setări Facturare ANAF', 'facturare-anaf-by-mihai'); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('facturare_anaf_settings_group');
                do_settings_sections('facturare_anaf_settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
new Admin_Settings_Page();
