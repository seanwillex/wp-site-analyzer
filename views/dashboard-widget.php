<div id="wpsa-dashboard-widget">
    <p>Click the button below to run a quick site analysis.</p>
    <button id="wpsa-run-quick-analysis" class="button button-secondary">Run Quick Analysis</button>
    <div id="wpsa-quick-results" style="display: none;">
        <h4>Quick Analysis Results</h4>
        <ul>
            <li id="wpsa-security-status"></li>
            <li id="wpsa-seo-status"></li>
            <li id="wpsa-code-errors-status"></li>
        </ul>
        <p><a href="<?php echo admin_url('admin.php?page=wp-site-analyzer'); ?>">View detailed results</a></p>
    </div>
    <div id="wpsa-quick-loading" style="display: none;">
        <p>Running quick analysis... Please wait.</p>
    </div>
</div>