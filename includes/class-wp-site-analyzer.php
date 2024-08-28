<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

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
        // Initialize admin hooks
        $this->admin->init();

        // Add AJAX actions
        add_action('wp_ajax_wpsa_run_analysis', array($this, 'run_analysis'));
    }

    public function run_analysis() {
        // Verify nonce for security
        check_ajax_referer('wpsa_nonce', 'nonce');

        $results = array(
            'security' => $this->security->analyze(),
            'seo' => $this->seo->analyze(),
            'code_errors' => $this->code_errors->analyze(),
        );

        wp_send_json_success($results);
    }
}