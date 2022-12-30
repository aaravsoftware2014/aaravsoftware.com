(function ($) {	$(document).ready(function(){

	"use strict";

    function gyanCustomizerManager() {

        var $page = $( '#gyan-customizer-manager-admin-page' );

        if ( ! $page.length) {
            return;
        }

        $( '.gyan-customizer-check-all' ).click( function() {
            $('.gyan-customizer-editor-checkbox').each( function() {
                this.checked = true;
            } );
            return false;
        } );

        $( '.gyan-customizer-uncheck-all' ).click( function() {
            $('.gyan-customizer-editor-checkbox').each( function() {
                this.checked = false;
            } );
            return false;
        } );

    }

    gyanCustomizerManager();

}); })(jQuery);