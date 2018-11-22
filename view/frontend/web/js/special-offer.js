define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';

    var options = {
        type: 'popup',
        autoOpen: true,
        responsive: true,
        innerScroll: false,
        title: 'popup modal title',
        buttons: [{
            text: $.mage.__('Continue'),
            class: '',
            click: function () {
                this.closeModal();
            }
        }]
    };

    return function(scriptParameters)
    {
        var displayTime = scriptParameters.displayTime;

        $('#modal-overlay').modal(options);

        setTimeout(
            function() {
                $('#modal-overlay').modal('closeModal');
            },
            displayTime
        );
    }
});