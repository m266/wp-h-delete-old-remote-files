<?php
error_reporting(0);
/*
Plugin Name:       WP H-Delete old Remote Files
Plugin URI:        https://web266.de/software/eigene-plugins/wp-h-delete-old-remote-files/
Description:       Automatisches L&ouml;schen alter Dateien per FTP auf Remote Server/NAS
Author:            Hans M. Herbrand
Author URI:        https://web266.de
Version:           1.0
Date:              2021-02-06
License:           GNU General Public License v2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/m266/wp-h-delete-old-remote-files
Credits:           https://www.carnaghan.com/knowledge-base/php-script-that-deletes-files-within-a-remote-directory-via-ftp-older-than-a-given-amount-of-days/
 */

// Externer Zugriff verhindern
defined('ABSPATH') || exit();

// Cronjob einmal taeglich
if (!wp_next_scheduled('wp_h_delete_hook')) {
    wp_schedule_event(time(), 'daily', 'wp_h_delete_hook');
}
add_action('wp_h_delete_hook', 'wp_h_delete_function');
function wp_h_delete_function() {
//    wp_mail('you@yoursite.com', 'Automatic email', 'Hello, this is an automatically scheduled email from WordPress.');
}

// Option Page einbinden
require_once 'inc/wphdorf_settings.php';

// Formular einbinden
require_once 'inc/wphdorf_delete.php';

// Hook Cronjob bei Deaktivierung entfernen
if (function_exists('register_deactivation_hook')) {
    register_deactivation_hook(__FILE__, 'wphdorf_deactivat');
}

// Cronjob entfernen
function wphdorf_deactivat() {
    $timestamp = wp_next_scheduled('wp_h_delete_hook');
    wp_unschedule_event($timestamp, 'wp_h_delete_hook');
// Geplant
    // Uncomment to clear hook if not being used anymore
    // wp_clear_scheduled_hook('pw_hook_schedule_weblink_token');
}