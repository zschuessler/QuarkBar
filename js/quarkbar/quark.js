/**
 * Copyright (c) 2012, Zachary Schuessler <zschuessler@deltasys.com>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 * 
 * - Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * - Neither the name of Brad Griffith nor the names of other contributors may 
 *   be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF 
 * THE POSSIBILITY OF SUCH DAMAGE.
 */

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
                    location.reload();
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
                    location.reload();
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
 *  Log user out
 */
jQuery(document).ready(function() {
    jQuery('#quark-logout').click(function() {
        var status = jQuery('#quark-nav-status');
        
        jQuery.ajax({
            url: '/quarkbar/ajax/logout',
            dataType: 'json',
            success: function(data) {
                if( data.status == 1 ) {
                    status.html(data.message);
                    status.show('fast').fadeOut(3000);
                    location.reload();
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