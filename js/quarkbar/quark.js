jQuery(document).ready(function() {
    jQuery('#quark-clear-cache').click(function() {
       jQuery.ajax({
         url: '/quarkbar/ajax/clearCache',
         success: function(data) {
             
         }
       });
    });
});