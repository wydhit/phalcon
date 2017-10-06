var helper = {
    init: function () {
        /* 用jqgrid的页面头部搜索用*/
        var searchForGrid = $('#searchForGrid');
        if (searchForGrid !== undefined) {
            searchForGrid.bind('submit', function () {
                try {
                    var formData = $(this).serializeArray(); //表单信息
                    var postData = {};
                    formData.forEach(function (data) {
                        postData[data.name] = data.value;
                    });
                    var grid_selector = $(this).data('grid');
                    if (grid_selector) {
                        dataGridHelper.gridSelectorAll[grid_selector].setGridParam({
                            'page': 1,
                            postData: {'searchData': postData}
                        }).trigger("reloadGrid"); //重新载入
                    }
                    return false;
                } catch (e) {
                    return false
                }
            });
        }
        /*使用jqgrid的页面头部搜索用*/
    },
    /*格式化unix时间戳*/
    unixTimeToStr: function (times) {
        if (times) {
            var date = new Date(times * 1000);
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
        } else {
            return '\\';
        }
    },
    changeAction: function (obj, successFn) {
        try {
            var href = $(obj).data('href');
            if (!href) {
                return false;
            }
            var title = $(obj).attr('title');
            if (!title) {
                title = '';
            }
            var data = {};
            this.confirm('您确定要' + title, '确定', 'x取消', function (result) {
                if (result) {
                    $.ajax({
                        url: href,
                        data: data,
                        dataType: 'json',
                        type: "POST",
                        success: function (backData) {
                            if (backData.status === 'success') {//执行成功
                                if (backData.message) {
                                    setTimeout(function () {
                                        helper.alertSuccess(backData.message, 1);
                                    }, 300);

                                }
                            } else {
                                setTimeout(function () {
                                    helper.alertError(backData.message, 20);
                                }, 300);
                            }
                            if (successFn && typeof successFn == "function") {
                                successFn(backData);
                            }
                        },
                        error: function () {
                            setTimeout(function () {
                                helper.alertError('请求失败，请刷新重试', 30);
                            }, 300);
                        }
                    });
                }
            });
            return false;
        } catch (e) {
            return false;
        }


    },
    'dialogInit': function () {
        //重写下jq ui 的dialog插件的title方法 让dialog的title可以支持html
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function (title) {
                var $title = this.options.title || '&nbsp;';
                if (("title_html" in this.options) && this.options.title_html == true)
                    title.html($title);
                else title.text($title);
            }
        }));
    },
    /*打开一个模拟对话框并加载一个网页*/
    'dialogOpen': function (obj) {
        this.dialogInit();
        var title = $(obj).attr('title') ? $(obj).attr('title') : '提示';
        var height = $(obj).data('height') ? $(obj).data('height') : 600;
        var width = $(obj).data('width') ? $(obj).data('width') : 800;
        var href = $(obj).data('href');
        href = helper.addInDialog(href);
        var dialogDivId = 'dialog-message' + parseInt(Math.random() * 1000000);
        var dialogHtml = '<div id="' + dialogDivId + '" class="hide">' +
            '   <div id="dialog-message-loading" >' +
            '       <div style="text-align: center;margin-top: 30px;">' +
            '       <i class="fa fa-spinner fa-spin orange" style="font-size:400%!important"></i> <br>' +
            '       <p>正在加载....</p> ' +
            '       </div>' +
            '   </div>' +
            '</div>'
        ;
        $('body').append(dialogHtml);
        var dialogObj = $('#' + dialogDivId);
        var mydialog = dialogObj.removeClass('hide').dialog({
            modal: true,
            closeOnEscape: true,
            width: width,
            height: height,
            position: {my: "center top+40", at: "center top+40"},
            title: "<div class='widget-header widget-header-small'><h4 class='smaller'>" + title + "</h4></div>",
            title_html: true,
            buttons: [
                {
                    text: "关闭",
                    "class": "btn btn-minier",
                    click: function (e) {
                        $(this).dialog("close");
                        mydialog.dialog("close");
                        $("#" + dialogDivId).remove();
                    }
                }
            ],
            close: function (event, ui) {
                $(this).dialog("close");
                mydialog.dialog("close");
                $("#" + dialogDivId).remove();
            }
        });
        if (href) {
            $.get(href, {}, function (result) {
                dialogObj.html(result);
            }, 'html');
        } else {
            dialogObj.html('没找到数据请求地址href');
        }
    },
    /*ajax提示表单*/
    submitByAjax: function (form, successFn, errorFn) {
        try {
            var data = $(form).serialize();
            var url = $(form).attr('action');
            $.ajax({
                cache: false,
                type: 'POST',
                url: url,
                data: data,
                dataType: 'json', //返回json格式数据
                success: function (json) {
                    if (json.status === 'success') {
                        if (successFn && typeof successFn == "function") {
                            successFn(json);
                        } else if (json.message) {
                            bootbox.alert(json.message);
                        }
                    } else {
                        if (errorFn && typeof errorFn == "function") {
                            errorFn(json);
                        } else if (json.message) {
                            bootbox.alert(json.message);
                        }
                    }
                },
                error: function (xhr, type, error) {
                    helper.alertError('提交失败');
                }
            });
            return false;
        } catch (e) {
            return false;
        }


    },
    formShowError: function (inputerr, form) {
        var obj;
        $(".help-block").remove();
        $(".form-group").removeClass('has-error');
        for (var ii in inputerr) {
            if (form !== undefined && form) {
                obj = $(form).find('#' + ii);
            } else {
                obj = $('#' + ii);
            }
            obj.focus().attr('aria-invalid', true)
                .removeClass('valid')
                .addClass('invalid')
                .parents('.form-group')
                .removeClass('has-info')
                .addClass('has-error')
                .append('<div id="' + ii + '-error" class="help-block">' + inputerr[ii] + '</div>');
        }
    },
    /*跳转*/
    goUrl: function (obj) {
        var url = $(obj).data('href');
        if (url) {
            location.href = url;
        } else {
            bootbox.alert('不可操作');
        }
    },
    go: function (url, time) {
        if (typeof time === 'undefined' || !time) {
            time = 1;
        }
        if (url) {
            location.href = url;
        } else {
            helper.alertError('不可操作');
        }
    },
    alert: function (type, title, message, closeTimer) {
        if (type !== 'success' && type !== 'error' && type !== 'warning') {
            type = 'warning';
        }
        if (!closeTimer) {
            closeTimer = 300000;
        }
        swal({
            title: title,
            text: message,
            type: type,
            timer: closeTimer * 1000,
            html: true,
            allowOutsideClick: true,
            confirmButtonText: '确定',
            confirmButtonColor: '#4F99C6',
            showLoaderOnConfirm: true
        });

    },
    alertSuccess: function (message, closeTimer) {
        if (!message) {
            message = '执行成功';
        }
        this.alert('success', message, '', closeTimer);
    },
    alertError: function (message, closeTimer) {
        if (!message) {
            message = '执行错误';
        }
        this.alert('error', '', message, closeTimer);
    },
    alertWarning: function (message, closeTimer) {
        if (!message) {
            message = '警告！';
        }
        this.alert('warning', message, '', closeTimer);
    },
    confirm: function (message, confirmButtonText, cancelButtonText, callback) {
        if (typeof callback !== "function") {
            callback = function () {
            }
        }
        swal({
            title: message,
            type: 'warning',
            allowOutsideClick: true,
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            confirmButtonColor: '#4F99C6',
            showCancelButton: true
        }, callback);
    },
    /**
     * 对jq validate封装
     * formId 表单id
     * jqValidateRules 验证规则
     * jqValidateMessages 验证规则信息
     * submitHandler  提交处理函数
     */
    validate: function (formId, jqValidateRules, jqValidateMessages, submitHandler) {
        if (typeof jqValidateRules !== 'object') {
            jqValidateRules = {};
        }
        if (typeof jqValidateMessages !== 'object') {
            jqValidateMessages = {};
        }
        if (typeof submitHandler !== 'function') {
            alert("警告！无法处理提交");
            return false;
        }
        $('#' + formId).validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            focusCleanup: true,
            onsubmit: true,
            ignore: "",
            rules: jqValidateRules,
            messages: jqValidateMessages,
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {

                $(e).closest('.form-group').removeClass('has-error')/*.addClass('has-info')*/;
                $(e).remove();
            },
            errorPlacement: function (error, element) {

                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if (element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                }
                else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },
            submitHandler: submitHandler,
            invalidHandler: function (form) {
            }
        });

    },
    /*对一个url加上inDialog参数*/
    addInDialog: function (href) {
        if (href.indexOf("inDialog") === -1) {
            if (href.indexOf('?') > -1) {
                href += "&inDialog=1";
            } else {
                href += "?inDialog=1";
            }
        }
        return href;
    }
};
$(function () {
    helper.init();
});

