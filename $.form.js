$(function() {

    /**
     * jQuery Form status
     */
    $.fn.formStatus = function(status, message) {

        // current form
        var form = $(this);
        // button && status
        var formButton = form.find('.form-button');
        var formStatus = from.find('.form-status');

        // reset status
        formStatus.empty();

        switch(status) {
            case 'loading':
                formButton.addClass('loading').attr('disabled', true);
            case 'success':
                formButton.removeClass('loading').attr('disabled', false);
                formStatus.html(formMessage);
            case 'error':
                formButton.removeClass('loading').attr('disabled', false);
                formStatus.html(formMessage);
            default:
                return false;
        }
    }

});