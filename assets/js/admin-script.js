jQuery(document).ready(function($) {
    function runAnalysis() {
        var $button = $('#wpsa-run-analysis');
        var $loading = $('#wpsa-loading');
        var $results = $('#wpsa-results');

        $button.prop('disabled', true);
        $loading.show();
        $results.hide();

        $.ajax({
            url: wpsa_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'wpsa_run_analysis',
                nonce: wpsa_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    displayResults(response.data);
                } else {
                    alert('An error occurred while analyzing the site. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while analyzing the site. Please try again.');
            },
            complete: function() {
                $button.prop('disabled', false);
                $loading.hide();
                $results.show().addClass('wpsa-fade-in');
            }
        });
    }

    function displayResults(data) {
        displayCategoryResults(data.security, $('#wpsa-security-results'));
        displayCategoryResults(data.seo, $('#wpsa-seo-results'));
        displayCategoryResults(data.code_errors, $('#wpsa-code-errors-results'));
    }

    function displayCategoryResults(category, $container) {
        var $list = $container.find('ul').empty();
        $.each(category, function(key, result) {
            var statusClass = result.status ? 'status-good' : 'status-bad';
            var $item = $('<li class="wpsa-result-item ' + statusClass + '">').appendTo($list);
            
            $item.append($('<h4>').text(formatTitle(key)));
            
            var $content = $('<div class="wpsa-result-content">').appendTo($item);
            $content.append($('<p>').text(result.message));
            $content.append($('<p class="wpsa-recommendation">').text('Recommendation: ' + result.recommendation));
            
            if (result.details) {
                $content.append($('<p class="wpsa-details">').text('Details: ' + result.details));
            }
            
            if ($content.height() > 100) {
                $content.css('max-height', '100px');
                var $readMore = $('<button class="wpsa-read-more">Read More</button>').appendTo($item);
                $readMore.on('click', function() {
                    if ($content.css('max-height') !== 'none') {
                        $content.css('max-height', 'none');
                        $(this).text('Read Less');
                    } else {
                        $content.css('max-height', '100px');
                        $(this).text('Read More');
                    }
                });
            }
        });
    }

    function formatTitle(key) {
        return key.split('_').map(function(word) {
            return word.charAt(0).toUpperCase() + word.slice(1);
        }).join(' ');
    }

    $('#wpsa-run-analysis').on('click', function() {
        runAnalysis();
    });
});