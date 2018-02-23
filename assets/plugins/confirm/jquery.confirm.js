/*!
 * jquery.confirm
 *
 * @version 2.3.1
 *
 * @author My C-Labs
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 * @author Russel Vela
 * @author Marcus Schwarz <msspamfang@gmx.de>
 *
 * @license MIT
 * @url https://myclabs.github.io/jquery.confirm/
 */
(function ($) {

    /**
     * Confirm a link or a button
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, submitForm, confirmButtonClass}}
     */
    $.fn.confirm = function (options) {
        if (typeof options === 'undefined') {
            options = {};
        }

        this.click(function (e) {
            e.preventDefault();

            var newOptions = $.extend({
                button: $(this)
            }, options);

            $.confirm(newOptions, e);
        });

        return this;
    };

    /**
     * Show a confirmation dialog
     * @param [options] {{title, text, confirm, cancel, confirmButton, cancelButton, post, submitForm, confirmButtonClass}}
     * @param [e] {Event}
     */
    $.confirm = function (options, e) {
        // Do nothing when active confirm modal.
        if ($('.confirmation-modal').length > 0)
            return;

        // Parse options defined with "data-" attributes
        var dataOptions = {};
        if (options.button) {
            var dataOptionsMapping = {
                'title': 'title',
                'text': 'text',
                'confirm-button': 'confirmButton',
                'submit-form': 'submitForm',
                'cancel-button': 'cancelButton',
                'confirm-button-class': 'confirmButtonClass',
                'cancel-button-class': 'cancelButtonClass',
                'dialog-class': 'dialogClass'
            };
            $.each(dataOptionsMapping, function(attributeName, optionName) {
                var value = options.button.data(attributeName);
                if (value) {
                    dataOptions[optionName] = value;
                }
            });
        }

        // Default options
        var settings = $.extend({}, $.confirm.options, {
            confirm: function () {
                if (dataOptions.submitForm){
                    e.target.closest("form").submit();
                } else {
                    var url = e && (('string' === typeof e && e) || (e.currentTarget && e.currentTarget.attributes['href'].value));
                    if (url) {
                        if (options.post) {
                            var form = $('<form method="post" class="hide" action="' + url + '"></form>');
                            $("body").append(form);
                            form.submit();
                        } else {
                            window.location = url;
                        }
                    }
                }
            },
            cancel: function (o) {
            },
            button: null
        }, dataOptions, options);

        // Modal
        var modalHeader = '';
        if (settings.title !== '') {
            modalHeader =
                '<div class="modal-header modal-heading">' +                    
                    '<p class="modal-title">' + settings.title+'</p>' +
                '</div>';
        }
        var modalHTML =
                '<div class="confirmation-modal modal-va-middle modal fade" tabindex="-1" role="dialog">' +
                    '<div class="'+ settings.dialogClass +'">' +
                        '<div class="modal-content">' +
                            modalHeader +
                            '<div class="modal-inner"><p class="h5 margin-top-sm text-black-hint modal-body">' + settings.text + '</p></div>' +
                            '<div class="modal-footer">' +
								'<p class="text-right">'+
                                '<button class="confirm btn ' + settings.confirmButtonClass + ' waves-attach" type="button" data-dismiss="modal">' +
                                    settings.confirmButton +
                                '</button>' +
                                '<button class="cancel btn ' + settings.cancelButtonClass + ' waves-attach" type="button" data-dismiss="modal">' +
                                    settings.cancelButton +
                                '</button>' +
								'</p>'+
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>';

        var this_modal = $(modalHTML);

        this_modal.on('shown.bs.modal', function () {
            this_modal.find(".btn-brand:first").focus();
        });
        this_modal.on('hidden.bs.modal', function () {
            this_modal.remove();
        });
        this_modal.find(".confirm").click(function () {
            settings.confirm(settings.button);
        });
        this_modal.find(".cancel").click(function () {
            settings.cancel(settings.button);
        });

        // Show the modal
        $("body").append(this_modal);
        this_modal.modal('show');
    };

    /**
     * Globally definable rules
     */
    $.confirm.options = {
        text: "Are you sure?",
        title: "",
        confirmButton: "Yes",
        cancelButton: "Cancel",
        post: false,
        submitForm: false,
        confirmButtonClass: "btn-flat btn-alt",
        cancelButtonClass: "btn-flat btn-brand-accent",
        dialogClass: "modal-dialog  modal-xs"
    }
})(jQuery);
