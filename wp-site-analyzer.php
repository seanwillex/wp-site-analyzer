<?php
/**
 * Plugin Name: WP Site Analyzer
 * Plugin URI: http://example.com/wp-site-analyzer
 * Description: Analyzes WordPress sites for security, SEO, and code errors, providing suggestions for improvements.
 * Version: 1.0
 * Author: Boma Nathaniel Williams
 * Author URI: https://www.linkedin.com/in/boma-williams/
 * License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WPSA_VERSION', '1.0');
define('WPSA_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPSA_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once WPSA_PLUGIN_DIR . 'includes/class-wp-site-analyzer-admin.php';
require_once WPSA_PLUGIN_DIR . 'includes/class-wp-site-analyzer-security.php';
require_once WPSA_PLUGIN_DIR . 'includes/class-wp-site-analyzer-seo.php';
require_once WPSA_PLUGIN_DIR . 'includes/class-wp-site-analyzer-code-errors.php';

class WP_Site_Analyzer {
    private $admin;
    private $security;
    private $seo;
    private $code_errors;

    public function __construct() {
        $this->admin = new WP_Site_Analyzer_Admin();
        $this->security = new WP_Site_Analyzer_Security();
        $this->seo = new WP_Site_Analyzer_SEO();
        $this->code_errors = new WP_Site_Analyzer_Code_Errors();
    }

    public function init() {
        $this->admin->init();
        add_action('wp_ajax_wpsa_run_analysis', array($this, 'run_analysis'));
    }

    public function run_analysis() {
        check_ajax_referer('wpsa_nonce', 'nonce');

        $results = array(
            'security' => $this->security->analyze(),
            'seo' => $this->seo->analyze(),
            'code_errors' => $this->code_errors->analyze(),
        );

        wp_send_json_success($results);
    }
}

function wp_site_analyzer_init() {
    $wp_site_analyzer = new WP_Site_Analyzer();
    $wp_site_analyzer->init();
}
add_action('plugins_loaded', 'wp_site_analyzer_init');