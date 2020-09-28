$(function() {
    'use strict';

    var myLanguage = {
        errorTitle: 'عزراً هنالك أخطاء !'
    };

    $.validate({
        form: '#form-save-element',
        modules: 'date,brazil',
        language: myLanguage,
        validateOnBlur: true,
        errorMessagePosition: 'left',
        onError: function() {
            //alert('Error');
            return;
        },
        onSuccess: function() {
            AddEditElement();
        }
    });

    $.validate({
        form: '#form-save-items',
        modules: 'date,brazil',
        language: myLanguage,
        validateOnBlur: true,
        errorMessagePosition: 'left',
        onError: function() {
            //alert('Error');
            return;
        },
        onSuccess: function() {
            AddEditItems();
        }
    });

    $.validate({
        form: '#form-element-search',
        language: myLanguage,
        validateOnBlur: true,
        errorMessagePosition: 'left',
        onError: function() {
            //alert('Error');
            return;
        },
        onSuccess: function() {
            $('.form-search-wrap').slideUp();
            SearchElement();
        }
    });

    $('#add-element').click(function(e) {
        e.preventDefault();
        $('form#form-save-element')[0].reset();
        INVOIC_ID();
        TOTAL_AMOUNT();
        $('#action').val("purchase.add");
        $('#modal-add-element .title-top').html('<span class="content-title"> <i class="fa fa-file-text-o"></i> أوامر الشراء <i class="fa fa-chevron-left"></i> <h3>إضافة أمر شراء جديدة</h3> </span>');
        $('#btn-save-element').attr('status', "1");
        $('#add').modal('show');
    });

    $('#btn-add-item').click(function(e) {
        e.preventDefault();
        $('form#form-save-items')[0].reset();
        $('#modal-add-element .item-header').html('<span class="content-title"> <i class="fa fa-file-text-o"></i> أوامر الشراء <i class="fa fa-chevron-left"></i> <h3>إضافة منتج للأمر شراء</h3></a></span>');
        $('#btn-item-save').attr('status', "1");
        $('#add-item').modal('show');
    });

    $("#ITEM_ID").change(function() {
        GetItemInvo();
        LastPrice();
    });
    // $('#STATUS').onchange();

    $('#form-save-element').submit(function() {
        return false;
    });

    $('#form-save-items').submit(function() {
        return false;
    });

    $('#form-element-search').submit(function() {
        return false;
    });

    // Active NavSiderBar

    $('.nav-item').removeClass('active-nav');
    $('.purchase').addClass('active-nav');

    // Delete Element .

    $('#btn-delete').click(function() {
        comfirmDelete($(this), event);
    });

    // show and hide insurance company .
    $("#STATUS").change(function() {
        if ($("#STATUS").val() == 1) {
            $('#COMPANY_ID').parent().slideDown(1000); //css("display","block");
        } else {
            $('#COMPANY_ID').parent().slideUp(1000); //.css("display","none");
        }
    });

    $("#COMPANY_ID").change(function() {
        CovertItems();
    });

    $('#COMPANY_ID').parent().css("display", "none");

    $("#ENTER_QTE,#ITEM_ID").keyup(function() {
        LastPrice();
    });

    $('#LAST_PRICE').css("direction", "ltr");

    // $("#ENTER_QTE").blur(function () {
    //     var a = $("#ENTER_QTE").val();
    //     var b = $('#QTE').val();
    //     console.log(a );
    //     console.log(b );
    //
    //     if ( b < a  )
    //     {
    //
    //         $.notify({
    //             // options
    //             icon: 'fa fa-exclamation-circle',
    //             title: '<strong>عزراً </strong> ... ',
    //             message: 'الكمية المدخلة غير متوفرة بالمحل حالياً أقصي حد هو '+ $('#QTE').val() +' وحدة !'
    //         },{
    //             // settings
    //             type: "danger",
    //             allow_dismiss: false,
    //             newest_on_top: false,
    //             showProgressbar: false,
    //             placement: {
    //                 from: "top",
    //                 align: "left"
    //             },
    //             offset: 20,
    //             spacing: 50,
    //             z_index: 9999,
    //             delay: 5000,
    //             timer: 1000,
    //             mouse_over: "pause",
    //             animate: {
    //                 enter: 'animated fadeInLeft',
    //                 exit: 'animated fadeOutLeft'
    //             }
    //         });
    //
    //         $(this).focus();
    //     }
    //
    // });

    // Load Emp .
    LoadElement();
    LoadItem();
    TOTAL_AMOUNT();
    $('#MOD').val(0);

});

function AddEditElement() {
    var btn = $('#btn-save-element').attr('status');

    if (btn == 1) {
        AddElement();
    } else {
        ComfirmEdit();
    }
}

function AddEditItems() {
    var btn = $('#btn-item-save').attr('status');

    if (btn == 1) {
        AddItems();
    } else {
        ComfirmEdit();
    }
}

function LastPrice() {
    var price = 0;
    var qte = 0;
    var value = 0;

    if ($('#SALE_PRICE').val() != "") {
        price = $('#SALE_PRICE').val();
    }

    if ($('#ENTER_QTE').val() != "") {
        qte = $('#ENTER_QTE').val();
    }

    if ($('#MOD').val() != "") {
        value = $('#MOD').val();
    }

    var total = 0;
    if ($("#STATUS").val() == 1) {
        var mod = (value * price) / 100;
        var net = price - mod;
        total = nFormat(net * qte);
    } else {
        total = nFormat(price * qte);
    }

    $('#LAST_PRICE').val(total);


}

function GetItemInvo() {
    var obj = {
        ajax_action: 'purchase.GetItemInvo',
        id: $("#ITEM_ID").val()
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            var items = JSON.parse(data);
            $('#SALE_PRICE').val(items.SALE_PRICE);
            $('#UNIT').val(items.UNIT);
            $('#QTE').val(items.QTE);
        },
        'html'
    );
}

function CovertItems() {
    var obj = {
        ajax_action: 'purchase.CovertItems',
        ITEM_ID: $("#ITEM_ID").val(),
        COMPANY_ID: $("#COMPANY_ID").val(),
    };

    var a;
    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            if (data == 0) {
                $('#MOD').val(0);
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong > تنبية  </strong> ... ',
                    message: ' هذا المنتج غير مؤمن من قبل هذه الشركة ! '
                }, {
                    // settings
                    type: "warning",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
            } else {
                var output = JSON.parse(data);
                $('#MOD').val(output.VALUE);
            }

        },
        'html'
    );
}

function AddElement() {

    var obj = {
        ajax_action: 'purchase.add',
        vendor_id: $("#vendor_id").val(),
        total_price: $("#TOTAL_AMOUNT").val(),
    };



    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            console.log(data);
            if (data == 1) {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم حفظ  </strong> ... ',
                    message: '  بيانات للأمر شراء بنجاح !'
                }, {
                    // settings
                    type: "success",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
                $('#add').modal('hide');
                LoadElement();
            } else if (data == 2) {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong > تنبية  </strong> ... ',
                    message: '  عفواً ... لم يتم إضافة أي أدوية للأمر شراء .'
                }, {
                    // settings
                    type: "warning",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
                LoadItem();
            } else {
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                }, {
                    // settings
                    type: "danger",
                    allow_dismiss: false,
                    newest_on_top: false,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 1000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
            }
        },
        'html'
    );

}

function AddItems() {

    var obj = {
        ajax_action: 'purchase.AddItems',
        purchase_order_id: $("#INVOIC_ID").val(),
        product_id: $("#ITEM_ID").val(),
        price: $("#price").val(),
        quantity: $("#quantity").val(),
        discount: $("#discount").val(),
    };

    var a;
    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            console.log(data);
            if (data == 1) {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم إضافة  </strong> ... ',
                    message: '  عنصر للأمر شراء بنجاح !'
                }, {
                    // settings
                    type: "success",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
                $('#add-item').modal('hide');
                LoadItem();
            } else if (data == 2) {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong > تنبية  </strong> ... ',
                    message: '  بيانات هذا العنصر موجوده مسبقاً ضمن أوامر الشراء .'
                }, {
                    // settings
                    type: "warning",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
                LoadItem();
            } else {
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                }, {
                    // settings
                    type: "danger",
                    allow_dismiss: false,
                    newest_on_top: false,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 1000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
            }

        },
        'html'
    );

}

function SearchElement() {
    var formData = new FormData($('form#form-element-search')[0]);
    $.ajax({
        url: '/PS_App/Public/index.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            $('.table-responsive .main-table tbody').html(data);

        }
    });
}

function LoadElement() {
    var obj = {
        ajax_action: 'purchase.load',
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            $('.main-table tbody').html(data);
            $('.table-responsive').hide().delay(1000);
            $('.table-responsive').slideDown(1000);
        },
        'html'

    );
}

function LoadItem() {
    var obj = {
        ajax_action: 'purchase.loadItem',
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            $('.item-table tbody').html(data);
            $('.item-table tbody').slideUp(1000);
            $('.item-table tbody').hide().delay(1000);
            $('.item-table tbody').slideDown(2000);
        },
        'html'

    );
    TOTAL_AMOUNT();
}

function EditElement(btn, e) {
    e.preventDefault();
    LoadElementEdit(btn);
    $('#btn-item-save').attr('status', "2");
    $('#modal-add-element .item-header').html('<span class="content-title"> <i class="fa fa-file-text-o"></i> أوامر الشراء <i class="fa fa-chevron-left"></i> <h3>تعديل بيانات أدوية أوامر الشراء</h3></a></span>');
    $('#add-item').modal('show', 2000);
}

function LoadElementEdit(btn) {
    var obj = {
        ajax_action: 'purchase.LoadElementEdit',
        ITEM_ID: $(btn).attr('element_id')
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            console.log(data);

            var output = JSON.parse(data);
            $('#ITEM_ID').val(output.product_id);
            $('#price').val(output.price);
            $('#quantity').val(output.quantity);
            $('#discount').val(output.discount);

            GetItemInvo();
            LastPrice();
        },
        'html'

    );
}

function INVOIC_ID() {
    var obj = {
        ajax_action: 'purchase.INVOIC_ID'
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            $('#INVOIC_ID').val(data);
        },
        'html'

    );
}

function TOTAL_AMOUNT() {
    var obj = {
        ajax_action: 'purchase.TOTAL_AMOUNT'
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            $('#TOTAL_AMOUNT').val(nFormat(data));
        },
        'html'

    );
}

function ComfirmEdit() {

    var obj = {
        ajax_action: 'purchase.EditItems',
        purchase_order_id: $("#INVOIC_ID").val(),
        product_id: $("#ITEM_ID").val(),
        price: $("#price").val(),
        quantity: $("#quantity").val(),
        discount: $("#discount").val(),
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            console.log(data);
            if (data == 1) {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم تحديث  </strong> ... ',
                    message: '  بيانات عنصر في أوامر الشراء بنجاح !'
                }, {
                    // settings
                    type: "success",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
                $('#add-item').modal('hide');
                LoadItem();
            } else {
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                }, {
                    // settings
                    type: "danger",
                    allow_dismiss: false,
                    newest_on_top: false,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 1000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
            }

        },
        'html'
    );

}

function DeleteOrder(btn, e) {
    e.preventDefault();
    $('#comfirm2').modal('show', 2000);
    $('#btn-delete-order').attr('element_id', $(btn).attr('element_id'));
}

function comfirmDeleteOrder(btn, e) {
    e.preventDefault();
    $('#comfirm2').modal('hide');
    var obj = {
        ajax_action: 'purchase.delete',
        id: $(btn).attr('element_id')
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            console.log(data);
            if (data == 1) {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم حذف  </strong> ... ',
                    message: '  بيانات أمر الشراء رقم ' + $(btn).attr('element_id') + '  بنجــاح .'
                }, {
                    // settings
                    type: "success",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
                LoadElement();
            } else {
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                }, {
                    // settings
                    type: "danger",
                    allow_dismiss: false,
                    newest_on_top: false,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 1000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
            }
        },
        'html'
    );

}

function DeleteElement(btn, e) {
    e.preventDefault();
    $('#comfirm').modal('show', 2000);
    $('#btn-delete').attr('element_id', $(btn).attr('element_id'));
}

function comfirmDelete(btn, e) {
    e.preventDefault();
    $('#comfirm').modal('hide');
    var obj = {
        ajax_action: 'purchase.deleteItem',
        ITEM_ID: $(btn).attr('element_id')
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data) {
            console.log(data);
            if (data == 1) {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم حذف  </strong> ... ',
                    message: '  بيانات العنصر رقم ' + $(btn).attr('element_id') + ' من أوامر الشراء بنجــاح .'
                }, {
                    // settings
                    type: "success",
                    allow_dismiss: false,
                    newest_on_top: true,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 2000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
                LoadItem();
            } else {
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                }, {
                    // settings
                    type: "danger",
                    allow_dismiss: false,
                    newest_on_top: false,
                    showProgressbar: false,
                    placement: {
                        from: "top",
                        align: "left"
                    },
                    offset: 20,
                    spacing: 50,
                    z_index: 9999,
                    delay: 5000,
                    timer: 1000,
                    mouse_over: "pause",
                    animate: {
                        enter: 'animated fadeInLeft',
                        exit: 'animated fadeOutLeft'
                    }
                });
            }
        },
        'html'
    );

}

function nFormat(number) {
    number = parseFloat(Math.round(number * 100) / 100).toFixed(2);
    return ("" + number).replace(/\B(?=(?:\d{3})+(?!\d))/g, "");
}