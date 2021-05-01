/*global $, window*/
$.fn.editableTableWidget = function (options) {
    'use strict';
    return $(this).each(function () {
        $('#notModel').remove();
        $('#isModel').remove();
        var buildDefaultOptions = function () {
                var opts = $.extend({}, $.fn.editableTableWidget.defaultOptions);
                opts.editor = opts.editor.clone();
                return opts;
            },
            activeOptions = $.extend(buildDefaultOptions(), options),
            ARROW_LEFT = 37, ARROW_UP = 38, ARROW_RIGHT = 39, ARROW_DOWN = 40, ENTER = 13, ESC = 27, TAB = 9,
            element = $(this),
            editor = activeOptions.editor.css('position', 'absolute').hide().appendTo(element.parent()),
            active,
            showEditor = function (select) {
                active = element.find('td:focus');
                if (active.length) {
                    if(active.data().type == "model_number")
                    {
                        editor.attr("id","isModel");
                    }
                    else
                    {
                        editor.attr("id","notModel");
                    }

                    editor.unbind('keypress');
                    editor.unbind('focusout');

                    $("#notModel").keypress(function(e){

                        e = e || window.event;
                        var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
                        var val = String.fromCharCode(charCode);

                        if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
                        {
                            e.preventDefault();
                            return false;
                        }

                        if(e.which == 44)
                        {
                            if(this.value.indexOf(',') > -1)
                            {
                                e.preventDefault();
                                return false;
                            }
                        }

                        var num = $(this).attr("maskedFormat").toString().split(',');
                        var regex = new RegExp("^\\d{0," + num[0] + "}(\\,\\d{0," + num[1] + "})?$");
                        if (!regex.test(this.value)) {
                            this.value = this.value.substring(0, this.value.length - 1);
                        }

                    });

                    $("#notModel").on('focusout',function(e){
                        if($(this).val().slice($(this).val().length - 1) == ',')
                        {
                            var val = $(this).val();
                            val = val + '00';
                            $(this).val(val);
                        }
                    });


                    editor.val(active.text())
                        .removeClass('error')
                        .show()
                        .offset(active.offset())
                        .css(active.css(activeOptions.cloneProperties))
                        .width(active.width())
                        .height(active.height())
                        .focus();
                    if (select) {
                        editor.select();
                    }
                }
            },
            setActiveText = function () {
                var text = editor.val(),
                    evt = $.Event('change'),
                    originalContent;
                if (active.text() === text || editor.hasClass('error')) {
                    return true;
                }
                originalContent = active.html();
                active.text(text).trigger(evt, text);
                active.parent().find('td[data-type="rate"]').css('border','');
                active.parent().find('td[data-type="sell_rate"]').css('border','');
                if (evt.result === false) {
                    active.html(originalContent);
                }
            },
            movement = function (element, keycode) {
                if (keycode === ARROW_RIGHT) {
                    return element.next('td');
                } else if (keycode === ARROW_LEFT) {
                    return element.prev('td');
                } else if (keycode === ARROW_UP) {
                    return element.parent().prev().children().eq(element.index());
                } else if (keycode === ARROW_DOWN) {
                    return element.parent().next().children().eq(element.index());
                }
                return [];
            };
        editor.blur(function () {
            setActiveText();
            editor.hide();
        }).keydown(function (e) {
            if (e.which === ENTER) {
                setActiveText();
                editor.hide();
                active.focus();
                e.preventDefault();
                e.stopPropagation();
            } else if (e.which === ESC) {
                editor.val(active.text());
                e.preventDefault();
                e.stopPropagation();
                editor.hide();
                active.focus();
            } else if (e.which === TAB) {
                active.focus();
            } else if (this.selectionEnd - this.selectionStart === this.value.length) {
                var possibleMove = movement(active, e.which);
                if (possibleMove.length > 0) {
                    possibleMove.focus();
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
        })
            .on('input paste', function () {
                var evt = $.Event('validate');
                active.trigger(evt, editor.val());
                if (evt.result === false) {
                    editor.addClass('error');
                } else {
                    editor.removeClass('error');
                }
            });
        element.find('td[data-editable!="false"]').on('click keypress dblclick', showEditor)
            .css('cursor', 'pointer')
            .keydown(function (e) {
                var prevent = true,
                    possibleMove = movement($(e.target), e.which);
                if (possibleMove.length > 0) {
                    possibleMove.focus();
                } else if (e.which === ENTER) {
                    showEditor(false);
                } else if (e.which === 17 || e.which === 91 || e.which === 93) {
                    showEditor(true);
                    prevent = false;
                } else {
                    prevent = false;
                }
                if (prevent) {
                    e.stopPropagation();
                    e.preventDefault();
                }
            });

        element.find('td[data-editable!="false"]').prop('tabindex', 1);

        $(window).on('resize', function () {
            if (editor.is(':visible')) {
                editor.offset(active.offset())
                    .width(active.width())
                    .height(active.height());
            }
        });
    });

};
$.fn.editableTableWidget.defaultOptions = {
    cloneProperties: ['padding', 'padding-top', 'padding-bottom', 'padding-left', 'padding-right',
        'text-align', 'font', 'font-size', 'font-family', 'font-weight',
        'border', 'border-top', 'border-bottom', 'border-left', 'border-right'],
    editor: $('<input type="text" maskedFormat="9,1">')
};
