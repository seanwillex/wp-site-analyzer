<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class WP_Site_Analyzer_Admin {
    public function init() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'WP Site Analyzer',
            'Site Analyzer',
            'manage_options',
            'wp-site-analyzer',
            array($this, 'display_admin_page'),
            'dashicons-chart-area',
            100
        );
    }

    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_wp-site-analyzer' !== $hook) {
            return;
        }

        wp_enqueue_style('wpsa-admin-styles', WPSA_PLUGIN_URL . 'assets/css/admin-styles.css', array(), WPSA_VERSION);
        wp_enqueue_script('wpsa-admin-script', WPSA_PLUGIN_URL . 'assets/js/admin-script.js', array('jquery'), WPSA_VERSION, true);

        wp_localize_script('wpsa-admin-script', 'wpsa_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wpsa_nonce'),
        ));
    }

    public function display_admin_page() {
        include WPSA_PLUGIN_DIR . 'views/admin-page.php';
    }
}