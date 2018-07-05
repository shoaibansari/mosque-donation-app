/**
 |---------------------------------------------------------------------
 | Application Helper
 | Author: Muhammad Adnan (adfriend2003@gmail.com)
 |---------------------------------------------------------------------
 |
 */

String.prototype.getFileExtension = function() {
    return /(?:\.([^.]+))?$/.exec(this.toString())[1];
}

Number.prototype.getFileExtension = Number.prototype.getFileSizeFormatted = function(decimals) {
    bytes = this.toString();
    if(bytes == 0) return '0 Byte';
    var k = 1024;
    var dm = decimals + 1 || 1;
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

var AppHelper = function() {

    var self = this, debug = true, instanceOfDialogFrame;

    this.init = function () {

        // ajax
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Overriding jQuery.validation method
        if ( typeof $.validator !== 'undefined' )
        {
            $.validator.methods.email = function (value, element) {
                return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
            }
        }

        if ( typeof $.fn.dataTable !== 'undefined' ) {
            $.extend($.fn.dataTable.defaults, {
                "lengthMenu": [[25, 50, 100, 250, -1], [25, 50, 100, 250, "All"]],
                "pageLength": 50
            });
        }

    }

    this.url = function( resource ) {
        if (typeof resource === 'undefined')
            resource = '';
        var u = $('body').data('url');
        u = typeof u === 'undefined' ? '' : u;
        u = u.substr(u.length - 1) === '/' ? u : u + "/";
        if ( resource )
            return u + (resource.substr(0, 1) === '/' ? resource.substr(1, resource.length) : resource);
        return u;
    }

    this.assetUrl = function ( resource ) {
        if (typeof resource === 'undefined')
            resource = '';
        var u = $('body').data('assets-url');
        u = typeof u === 'undefined' ? '' : u;
        u = u.substr(u.length - 1) === '/' ? u : u + "/";
        if (resource)
            return u + (resource.substr(0, 1) === '/' ? resource.substr(1, resource.length) : resource);
        return u;
    }

    this.visit = function (url) {
        location.href = url;
    }

    this.back = function () {
        if (typeof document.referrer == 'undefined' || !document.referrer) {
            window.history.go(-1);
        }
        else {
            window.location.href = document.referrer;
        }
    }

    this.cookie = function (name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }



    this.blockPage = function (message) {
        message = typeof message === 'undefined' || "" ? "Please wait..." : message;
        $.blockUI({
            message: message,
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff',
                fontSize: '36pt'
            }
        });
    }

    this.unblockPage = function () {
        $.unblockUI();
    }

    this.logDebug = function (data) {
        if (typeof console !== 'undefined' && console.log && self.debug) {
            console.info(data);
        }
    }

    this.logError = function (data) {
        if (typeof console !== 'undefined' && console.log) {
            console.error(data);
        }
    }

    this.ajaxForm = function ( form, options ) {

        if ( typeof form !== 'object' ) {
            form = $(form)[0];  // getting native element from jquery object
        }

        var defaults = {
            url: form.action,
            method: form.method,
            data: $(form).serialize()
        };

        options = jQuery.extend({}, defaults, options);
        return this.ajax(form.action, options);
    }

    this.ajax = function (url, options) {

        var defaults = {
            url: url,
            method: 'GET',
            dataType: 'json',
            data: null,
            block: true,
            blockPage: true,
            blockElement: null,
            blockMessage: 'Please wait...',
            inlineElement: null,
            inlineLoader: appHelper.assetUrl('/images/ajax/hourglass.gif')
        };
        options = jQuery.extend({}, defaults, options);

        var ajaxSettings = {
            url: url,
            method: options.method,
            dataType: options.dataType,
            data: options.data,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        };


        if (typeof options.beforeSend !== 'undefined' && typeof options.beforeSend !== 'function') {
            throw new Error('"beforeSend" parameter should be function');
        }

        ajaxSettings.beforeSend = function (jqXHR, settings) {

            if (options.block) {

                if (options.inlineElement) {
                    $(options.inlineElement).hide();
                    $(options.inlineElement).parent().append('<img id="ajax-inline-loader" src="' + options.inlineLoader + '">');
                }

                if (options.blockElement) {
                    $(options.blockElement).block({message: options.blockMessage});
                }
                else if (options.blockPage) {
                    $.blockUI({
                        message: options.blockMessage,
                        css: {
                            border: 'none',
                            padding: '15px',
                            //backgroundColor: '#000',
                            backgroundColor: 'none',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .5,
                            color: '#fff',
                            fontSize: '36pt'
                        }
                    });
                }
            }

            if (typeof options.beforeSend === 'function') {
                options.beforeSend(jqXHR, settings);
            }
        }


        if (typeof options.complete !== 'undefined' && typeof options.complete !== 'function') {
            throw new Error('"complete" parameter should be function');
        }
        ajaxSettings.complete = function (jqXHR, textStatus) {
            if (options.inlineElement) {
                $(options.inlineElement).parent().find("#ajax-inline-loader").remove();
                $(options.inlineElement).show();
            }
            if (options.block) {
                if (options.blockElement) {
                    $(options.blockElement).unblock({message: options.blockMessage});
                }
                else if (options.blockPage) {
                    setTimeout(function() {
                        $.unblockUI();
                    }, 250);
                }
            }
            if (typeof options.complete === 'function') {
                options.complete(jqXHR, textStatus);
            }
        }

        if (typeof options.error !== 'undefined' && typeof options.error !== 'function') {
            throw new Error('"error" parameter should be function');
        }
        ajaxSettings.error = function (jqXHR, textStatus, errorThrown) {
            var response = (json = self.toJSON(jqXHR.responseText, true)) ? json : jqXHR.responseText;
            var error = {
                'code': jqXHR.status,
                'message': typeof response === 'object' ? response.message : errorThrown,
                'response': response,
                'jsonType': typeof response === 'object'
            };
            if (typeof options.error === 'function') {
                options.error(error, jqXHR, textStatus, errorThrown);
            }
        }

        if (typeof options.success === 'function') {
            ajaxSettings.success = function ( data, textStatus, jqXHR ) {
                options.success(data, textStatus, jqXHR);
            }
        }

        return jQuery.ajax(ajaxSettings);
    }

    this.toJSON = function( data, onErrorLogError ) {
        try {
            return $.parseJSON(data);
        } catch(e) {
            if ( typeof onErrorLogError !== 'undefined' && onErrorLogError )
                return false;
            self.logError({'error': "Unable to parse data into JSON format.", 'data': data} );
        }
        return false;
    }

    this.getIcon = function (ext) {
        var icon = 'fa-file-o';
        switch (ext.toLowerCase()) {
            case 'doc':
            case 'docx':
            case 'rtf':
                icon = 'fa-file-word-o';
                break;
            case 'zip':
            case 'rar':
            case 'bzip':
                icon = 'fa-file-archive-o';
                break;
            case 'php':
            case 'js':
            case 'html':
            case 'htm':
            case 'css':
                icon = 'fa-file-code-o';

        }
        return '<i class="fa ' + icon + '"></i>';
    }

    this.hideAlert = function( context ) {
        var $alert;
        if ( typeof context !== 'undefined' )
            $alert = $('.alert', context);
        else
            $alert = $('.alert');
        $alert.fadeOut();
        $alert.remove();
    }

    /**
     * Show alert message
     *
     * @param message
     * @param options
     */
    this.showAlert = function (message, options) {

        var defaults = {
            container: $(".alert-container"),
            message: message,
            type: 'info',   // "danger", "warning", "success", "info"
            dismissible: true,
            dismissTime: 0,
            fontIcons: true,
            mode: 'prepand' // prepand or append
        };

        options = jQuery.extend({}, defaults, options);

        var $container = (typeof options.container === 'object') ? options.container : $(options.container);
        if (!$container || !$container.length) {
            throw new Error('The container element is missing, specify one or add the default "div.alert-container".');
        }

        var icon = "";
        if (options.icons) {
            switch (options.type) {
                case 'danger':
                    icon = '<strong><i class="fa-lg fa fa-exclamation-triangle" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i></strong> ';
                    break;
                case 'warning':
                    icon = '<strong><i class="fa-lg fa fa-warning" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i></strong> ';
                    break;
                case 'success':
                    icon = '<strong><i class="fa-lg fa fa-check" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i></strong> ';
                    break;
                case 'info':
                default:
                    icon = '<strong><i class="fa-lg fa fa-info-circle" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i></strong> ';
                    break;
            }
        }

        var html = '<div class="alert alert-' + options.type + ( options.dismissible ? ' alert-dismissable' : '') + '">';
        if (options.dismissible) {
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
        }
        html += icon + message;
        html += '</div>';

        if ($container.find(".alert").length > 0) {
            $container.find(".alert").fadeOut('fast').remove();
        }

        if (options.mode === 'prepand') {
            $(html).hide().prependTo($container).fadeIn('fast');
        }
        else {
            $(html).hide().appendTo($container).fadeIn('fast');
        }

        if (options.dismissTime) {
            setTimeout(function () {
                self.hideAlert();
            }, options.dismissTime);
        }

        return $container;
    }

    this.validate = function(formElement, options) {
        formElement = typeof formElement === 'object' ? formElement : $(formElement);
        options = $.extend(true, {
            errorElement: 'span',
            errorClass: 'help-block error-help-block',
            focusInvalid: false,
            ignore: [],
            invalidHandler: function(event, validator) {
                appHelper.showAlert('The form has some errors. Please correct them and try again.', {'type': 'danger'});
                //console.log( validator.numberOfInvalids() );
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            success: function (label, element) {
                $(element).closest('.form-group').removeClass('has-error'); //.addClass('has-success');
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                appHelper.hideAlert();
                form.submit();
            }
        }, options);

        $.validator.methods.email = function (value, element) {
            return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        }
        formElement.validate(options);
    }

    this.confirm = function ( e, options ) {

        e.preventDefault();

        options = jQuery.extend(true, {
            'message': 'Are you sure?',
            'details': '',
            'confirmButtonText': "Yes",
            'type': 'warning',
            'confirmButtonColor': "#DD6B55",
            'closeOnConfirm': true,
            'showCancelButton': true

        }, options);

        swal({
            title: options.message,
            text: options.details,
            type: options.type,
            showCancelButton: options.showCancelButton,
            confirmButtonColor: options.confirmButtonColor,
            confirmButtonText: options.confirmButtonText,
            closeOnConfirm: options.closeOnConfirm
        }, function () {
            if ( typeof options.onConfirm === 'function' ) {
                options.onConfirm.call();
            }
        });
    }

    /**
     *
     * @param options
     * @returns {*}
     */
    this.showFrameDialog = function ( options ) {

        options = jQuery.extend( true, {
            'selector': '.mdf-modal-frame-window',
            'url': "",
            'title': "",
            'width': 'auto',
            'height': 'auto',
            'iframeWidth': 'auto',
            'onShow': function () {

            },
            'onHide': function () {

            },
            'buttons': [
                // {
                //     'label': "Test",
                //     'class': '',
                //     'onClick': function (event) {
                //     }
                // }
            ],

            'closeButton': {
                'label': 'Close',
                'show': true,
                'class': '',
                'confirmation': true,
                'message': 'Are you sure to close?',
                'onClick': ''
            }
        }, options);
        //console.log(options);

        var iframe = '#' + options.selector.substr(1) + '-modal-iframe';

        // removing if already exists.
        if (jQuery(options.selector).size() > 0) {
            jQuery(options.selector).remove();
        }

        var id = options.selector.substr(0, 1) == '#' ? 'id="'+ options.selector.substr(1)+'"' : '';
        var className = options.selector.substr(0,1) == '.' ? options.selector.substr(1) : '';
        var html = '<div '+ id +' class="'+ className +' modal fade" tabindex="-1" role="dialog" >'
        + '<div class="modal-dialog" role="document">'
        + '<div class="modal-content">';

        if ( options.title ) {
            html += '    <div class="modal-header">'
            html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
            html += '       <h4 class="modal-title"></h4>'
            html += '   </div>'
        }

        var iframeWidth = !options.iframeWidth || options.iframeWidth == 'auto' ? '99%' : options.iframeWidth;
        html += '   <div class="modal-body">'
        html += '       <iframe name="' + iframe.substr(1) + '" id="' + iframe.substr(1) + '" src="" frameborder="0" style="width:'+ iframeWidth +';" height="100%"></iframe>'
        html += '   </div>'

        html += '   <div class="modal-footer">'
        html += '       <div class="col-md-offset-3 col-md-9">';

        if (typeof options === 'object' && typeof options.buttons === 'object') {
            var bns = options.buttons;
            for (var i in bns) {
                var b = '<button'
                    + ' id="' + options.selector.substr(1) + '-button-index-' + i + '"'
                    + ' type="button" '
                    + ' class="btn ' + (typeof bns[i].class != 'undefined' ? bns[i].class : '') + '"'
                    + ' data-button-index="' + i + '">'
                    + (typeof bns[i].label != 'undefined' ? bns[i].label : "Undefined")
                    + '</button>';
                html += b;
            }
        }

        if ( typeof options.closeButton == 'object' && options.closeButton.show ) {

            html += '<button type="button" class="btn red mdf-bn-cancel ' + options.closeButton.class + '">' + options.closeButton.label + '</button>';
        }

        html += '       </div>'
            + '       </div>'
            + '    </div>'  // <div class="modal-content">
            + '  </div>'   // <div role="document">
            + '</div>';  // <div role="dialog">
        jQuery(html).appendTo('body');


        var $dialog = jQuery( options.selector );
        $dialog.data( 'options', options );
        $dialog.find('.modal-title').html( options.title );

        // events binding
        $dialog.on('show.bs.modal', function (e) {

            var $this = jQuery(this);
            $(iframe).attr('src', options.url);

            if ( options.width == 'auto')
                options.width = jQuery(window).width() - (jQuery(window).width() * 0.2) ;
            if (options.height == 'auto')
                options.height = jQuery(window).height() - (jQuery(window).height() * 0.2);

            $this.width( options.width );
            $this.height( options.height );

            var headerHeight = options.title ? 60 : 0;
            var footerHeight = 100;
            $(iframe).css('height', options.height - (headerHeight + footerHeight) );

            $this.css({
                'position': 'absolute',
                'margin': 'auto',
                // 'left': (jQuery(window).width() - options.width) / 2,
                // 'top': (jQuery(window).height() - options.height) / 2,
            });

            // onShow ( event, iframe.contentWindow )
            if ( typeof options.onShow === 'function') {
                options.onShow.call(e, $(iframe)[0].contentWindow);
            }

            // closeButton.onClose ( event, iframe.contentWindow, modal )
            if (typeof options.closeButton.onClick === 'function') {
                jQuery('.mdf-bn-cancel', $this).on('click', function (e) {
                    options.closeButton.onClick(e, $(iframe)[0].contentWindow, jQuery(this).closest('.modal'));
                });
            }
            else if ( options.closeButton.show ) {
                jQuery('.mdf-bn-cancel', $this).on('click', function (e) {
                    var bn = this;
                    if ( !options.closeButton.confirmation || !options.closeButton.message ) {
                        jQuery(bn).closest('.modal').modal('hide');
                    }
                    else {
                        if (typeof appHelper.confirm === 'function') {   // checking new function
                            appHelper.confirm(options.closeButton.message, function () {
                                jQuery(bn).closest('.modal').modal('hide');
                            });
                        }
                        else {
                            if (confirm(options.closeButton.message)) {
                                jQuery(bn).closest('.modal').modal('hide');
                            }
                            return false;
                        }
                    }
                });
            }

            // buttons event binding
            if ( typeof options.buttons === 'object') {
                var bns = options.buttons;
                for (var i in bns) {
                    if (typeof bns[i].onClick === 'function') {
                        $(document).on('click', '#' + options.selector.substr(1) + '-button-index-' + i, function (e) {
                            bns[$(this).data('button-index')].onClick(e, $(iframe)[0].contentWindow);
                        });
                    }
                }
            }
        });

        // onHide
        $dialog.on('hide.bs.modal', function (e) {
            jQuery('.mdf-bn-cancel', $dialog).off('click');
            if (typeof options === 'object' && typeof options.buttons === 'object') {
                var bns = options.buttons;
                for (var i in bns) {
                    if (typeof bns[i].onClick == 'function') {
                        $(document).off('click', '#' + options.selector.substr(1) + '-button-index-' + i);
                    }
                }
            }
            jQuery(this).find('iframe').attr('src', '');
        });

        $dialog.modal('toggle');
        return self.instanceOfDialogFrame = $dialog;

    } // end of function

    this.disposeModalFrame = function(data) {
        if (!self.instanceOfDialogFrame)
            return;

        self.instanceOfDialogFrame.modal('hide');
        self.instanceOfDialogFrame = null;
    }


    this.select2 = function (element, url_or_data, placeholder, multiple, minimumLength) {
        var options = {
            width: "off",
            ajax: {
                url: url_or_data,
                dataType: 'json',
                delay: 150,
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: data.items
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: typeof minimumLength == 'undefined' ? 0 : minimumLength,
            templateResult: function (response) {
                return response.name;
            },
            templateSelection: function (response) {
                return response.name || response.text;
            }
        };

        if ( !url_or_data ) {
            delete options.ajax;
        }

        if ( typeof url_or_data === 'object' ) {
            options.data = url_or_data;
        }

        if (placeholder != 'undefined') {
            options.placeholder = placeholder;
        }
        if (multiple != 'undefined') {
            options.multiple = multiple;
            options.tags = true;
        }
        // if (data !== 'undefined') {
        //     options.data = data;
        // }
        jQuery(element).select2(options);
    }

    this.parseErrors = function(errors) {
        var html = "Please correct the following error(s):<br>";
        if ( typeof errors === 'object' && typeof errors.response === 'object') {
            console.log( errors );
            html += "<ul style='display:inline-block'>";
            for (var i in errors.response) {
                html += "<li>" + (typeof errors.response[i] === "string" ? errors.response[i] : errors.response[i][0]) + "</li>";
            }
            html += "</ul>";
        }
        else {
            html += errors;
        }
        return html;
    }


    this.showSuccessNotification = function (text, options) {
        options = jQuery.extend(true, {
            colorName: 'bg-black',
            icon: 'glyphicon glyphicon-ok'
        }, options);
        self.showNotification(text, options);
    }

    this.showErrorNotification = function (text, options) {
        options = jQuery.extend( true, {
            colorName: 'bg-deep-orange',
            icon: 'glyphicon glyphicon-warning'
        }, options);
        self.showNotification( text, options );
    }

    this.showNotification = function(text, options) {

        options = jQuery.extend(true, {
            text: text ? text : 'Notification text is missing',
            colorName: 'bg-black',
            animateEnter: 'animated bounceInDown',
            animateExit: 'animated bounceOutDown',
            placementFrom: 'top',
            placementAlign: 'right',
            allowDismiss: true,
            icon: 'glyphicon glyphicon-ok',
            timer: 500
        }, options);


        $.notify({
                message: options.text,
                icon: options.icon
            },
            {
                type: options.colorName,
                allow_dismiss: options.allowDismiss,
                newest_on_top: true,
                timer: options.timer,
                placement: {
                    from: options.placementFrom,
                    align: options.placementAlign
                },
                animate: {
                    enter: options.animateEnter,
                    exit: options.animateExit
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (options.allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message" style="padding-left: 3px;">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
            });
    }


}

var appHelper = new AppHelper();
appHelper.init();
