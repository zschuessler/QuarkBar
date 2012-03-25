
/**
 *  Clear the Magento cache
 */
jQuery(document).ready(function() {
    jQuery('#quark-clear-cache').click(function() {
        var status = jQuery('#quark-nav-status');

        jQuery.ajax({
            url: '/quarkbar/ajax/clearCache',
            dataType: 'json',
            success: function(data) {
                if( data.status == 1 ) {
                    status.html(data.message);
                    status.show('fast').fadeOut(3000);
                } else {
                    status.show('fast');
                }
            },
            error: function(data, textStatus) {
                status.html(textStatus);
                status.show('fast');
            }
        });
    });
});


/**
 *  Rebuild Magento Indexes
 */
jQuery(document).ready(function() {
    jQuery('#quark-rebuild-indexes').click(function() {
        var status = jQuery('#quark-nav-status');

        jQuery.ajax({
            url: '/quarkbar/ajax/rebuildIndexes',
            dataType: 'json',
            success: function(data) {
                if( data.status == 1 ) {
                    status.html(data.message);
                    status.show('fast').fadeOut(3000);
                } else {
                    status.show('fast');
                }
            },
            error: function(data, textStatus) {
                status.html(textStatus);
                status.show('fast');
            }
        });
    });
});