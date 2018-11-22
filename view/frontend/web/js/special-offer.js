define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    var options = {
        type: 'popup',
        autoOpen: false,
        responsive: true,
        innerScroll: false,
        title: 'Special offer',
        buttons: []
    };

    return function(scriptParameters)
    {
        var displayTimeout = scriptParameters.displayTimeout;

        $('#modal-overlay').modal(options);

        setTimeout(
            function() {
                $('#modal-overlay').modal('openModal');
            },
            displayTimeout
        );
    }
});