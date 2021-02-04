<?php
// Option Page
class WPHDeleteOldRemoteFiles {
    private $wp_h_delete_old_remote_files_options;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'wp_h_delete_old_remote_files_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'wp_h_delete_old_remote_files_page_init' ) );
    }

    public function wp_h_delete_old_remote_files_add_plugin_page() {
        add_menu_page(
            'WP H-Delete old Remote Files', // page_title
            'WP H-Delete old Remote Files', // menu_title
            'manage_options', // capability
            'wp-h-delete-old-remote-files', // menu_slug
            array( $this, 'wp_h_delete_old_remote_files_create_admin_page' ), // function
            'dashicons-admin-tools', // icon_url
            76 // position
        );
    }

    public function wp_h_delete_old_remote_files_create_admin_page() {
        $this->wp_h_delete_old_remote_files_options = get_option( 'wp_h_delete_old_remote_files_option_name' ); ?>

        <div class="wrap">
<h2>
WP H-Delete old Remote Files 1.0 > Einstellungen
</h2>
<div class="card">
        <h3><b>(Das Plugin ist auf <a href="https://web266.de/software/eigene-plugins/wp-h-delete-old-remote-files/" target="_blank">web266.de</a> detailliert beschrieben)</b></h3>
            <hr>
            <?php settings_errors(); ?>

            <form method="post" action="options.php">
                <?php
                    settings_fields( 'wp_h_delete_old_remote_files_option_group' );
                    do_settings_sections( 'wp-h-delete-old-remote-files-admin' );
                    submit_button();
                ?>
            </form>
        </div>
        </div>
    <?php }

    public function wp_h_delete_old_remote_files_page_init() {
        register_setting(
            'wp_h_delete_old_remote_files_option_group', // option_group
            'wp_h_delete_old_remote_files_option_name', // option_name
            array( $this, 'wp_h_delete_old_remote_files_sanitize' ) // sanitize_callback
        );

        add_settings_section(
            'wp_h_delete_old_remote_files_setting_section', // id
            'Zugangsdaten f&uuml;r den FTP-Server:', // title
            array( $this, 'wp_h_delete_old_remote_files_section_info' ), // callback
            'wp-h-delete-old-remote-files-admin' // page
        );

        add_settings_field(
            'server_0', // id
            'Server', // title
            array( $this, 'server_0_callback' ), // callback
            'wp-h-delete-old-remote-files-admin', // page
            'wp_h_delete_old_remote_files_setting_section' // section
        );

        add_settings_field(
            'benutzer_1', // id
            'Benutzer', // title
            array( $this, 'benutzer_1_callback' ), // callback
            'wp-h-delete-old-remote-files-admin', // page
            'wp_h_delete_old_remote_files_setting_section' // section
        );

        add_settings_field(
            'passwort_2', // id
            'Passwort', // title
            array( $this, 'passwort_2_callback' ), // callback
            'wp-h-delete-old-remote-files-admin', // page
            'wp_h_delete_old_remote_files_setting_section' // section
        );

        add_settings_field(
            'pfad_auf_dem_server_3', // id
            'Pfad Remote Server', // title
            array( $this, 'pfad_auf_dem_server_3_callback' ), // callback
            'wp-h-delete-old-remote-files-admin', // page
            'wp_h_delete_old_remote_files_setting_section' // section
        );

        add_settings_field(
            'intervall_tage_4', // id
            'Intervall (Tage)', // title
            array( $this, 'intervall_tage_4_callback' ), // callback
            'wp-h-delete-old-remote-files-admin', // page
            'wp_h_delete_old_remote_files_setting_section' // section
        );
    }

    public function wp_h_delete_old_remote_files_sanitize($input) {
        $sanitary_values = array();
        if ( isset( $input['server_0'] ) ) {
            $sanitary_values['server_0'] = sanitize_text_field( $input['server_0'] );
        }

        if ( isset( $input['benutzer_1'] ) ) {
            $sanitary_values['benutzer_1'] = sanitize_text_field( $input['benutzer_1'] );
        }

        if ( isset( $input['passwort_2'] ) ) {
            $sanitary_values['passwort_2'] = sanitize_text_field( $input['passwort_2'] );
        }

        if ( isset( $input['pfad_auf_dem_server_3'] ) ) {
            $sanitary_values['pfad_auf_dem_server_3'] = sanitize_text_field( $input['pfad_auf_dem_server_3'] );
        }

        if ( isset( $input['intervall_tage_4'] ) ) {
            $sanitary_values['intervall_tage_4'] = sanitize_text_field( $input['intervall_tage_4'] );
        }

        return $sanitary_values;
    }

    public function wp_h_delete_old_remote_files_section_info() {

    }

    public function server_0_callback() {
        printf(
            '<input class="regular-text" type="text" placeholder="FTP-Server (Port 21)"name="wp_h_delete_old_remote_files_option_name[server_0]" id="server_0" value="%s">',
            isset( $this->wp_h_delete_old_remote_files_options['server_0'] ) ? esc_attr( $this->wp_h_delete_old_remote_files_options['server_0']) : ''
        );
    }

    public function benutzer_1_callback() {
        printf(
            '<input class="regular-text" type="text" placeholder="FTP-Benutzer"name="wp_h_delete_old_remote_files_option_name[benutzer_1]" id="benutzer_1" value="%s">',
            isset( $this->wp_h_delete_old_remote_files_options['benutzer_1'] ) ? esc_attr( $this->wp_h_delete_old_remote_files_options['benutzer_1']) : ''
        );
    }

    public function passwort_2_callback() {
        printf(
            '<input class="regular-text" type="password" placeholder="FTP-Passwort"name="wp_h_delete_old_remote_files_option_name[passwort_2]" id="passwort_2" value="%s">',
            isset( $this->wp_h_delete_old_remote_files_options['passwort_2'] ) ? esc_attr( $this->wp_h_delete_old_remote_files_options['passwort_2']) : ''
        );
    }

    public function pfad_auf_dem_server_3_callback() {
        printf(
            '<input class="regular-text" type="text" placeholder="Absoluter Pfad; muss vorhanden sein (z. B. /backup/)"name="wp_h_delete_old_remote_files_option_name[pfad_auf_dem_server_3]" id="pfad_auf_dem_server_3" value="%s">',
            isset( $this->wp_h_delete_old_remote_files_options['pfad_auf_dem_server_3'] ) ? esc_attr( $this->wp_h_delete_old_remote_files_options['pfad_auf_dem_server_3']) : ''
        );
    }

    public function intervall_tage_4_callback() {
        printf(
            '<input class="regular-text" type="number" placeholder="Intervall in Tagen" name="wp_h_delete_old_remote_files_option_name[intervall_tage_4]" id="intervall_tage_4" value="%s">',
            isset( $this->wp_h_delete_old_remote_files_options['intervall_tage_4'] ) ? esc_attr( $this->wp_h_delete_old_remote_files_options['intervall_tage_4']) : ''
        );
    }


}
if ( is_admin() )
    $wp_h_delete_old_remote_files = new WPHDeleteOldRemoteFiles();


// * Retrieve this value with:
$wp_h_delete_old_remote_files_options = get_option( 'wp_h_delete_old_remote_files_option_name' ); // Array of All Options
$server_0 = $wp_h_delete_old_remote_files_options['server_0']; // Server
$benutzer_1 = $wp_h_delete_old_remote_files_options['benutzer_1']; // Benutzer
$passwort_2 = $wp_h_delete_old_remote_files_options['passwort_2']; // Passwort
$pfad_auf_dem_server_3 = $wp_h_delete_old_remote_files_options['pfad_auf_dem_server_3']; // Pfad Remote Server
$intervall_tage_4 = $wp_h_delete_old_remote_files_options['intervall_tage_4']; // Interval (Tage)
?>