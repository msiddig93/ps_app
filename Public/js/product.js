$(function(){
   	'use strict';

   	var myLanguage = {
   		errorTitle : 'عزراً هنالك أخطاء !'
   	};

   	$.validate({
   		form:'#form-save-element',
   		language : myLanguage,
   		validateOnBlur : true,
   		errorMessagePosition : 'left',
   		onError : function(){
   			//alert('Error');
			return;
   		},
   		onSuccess : function(){
            AddEditElement();
   		}
   	});

   	$.validate({
			form:'#form-element-search',
			language : myLanguage,
			validateOnBlur : true,
			errorMessagePosition : 'left',
			onError : function(){
				//alert('Error');
				return;
			},
			onSuccess : function(){
                $('.form-search-wrap').slideUp();
				SearchElement();
			}
		});

      $('#add-element').click(function(e) {
      	e.preventDefault();
          $('form#form-save-element')[0].reset();
          LoadElementImg(0);
          $('#action').val("product.add");
          $('#modal-add-element .title-top').html('<span class="content-title"> <i class="fa fa-list-alt"></i> المنتجات <i class="fa fa-chevron-left"></i> <h3>إضافة منتج جديد</h3> </span>');
          $('#btn-save-element').attr('status',"1");
         $('#add').modal('show');
      });

    $('#form-save-element').submit(function(){
    	return false;
    });

    $('#form-element-search').submit(function(){
    	return false;
    });

    // Active NavSiderBar

	$('.nav-item').removeClass('active-nav');
	$('.stock').addClass('active-nav');

	// Delete Element .

    $('#btn-delete').click(function () {
        comfirmDelete($(this), event);
    });

    // Load Emp .
    LoadEmp();

});

function AddEditElement() {
    var btn = $('#btn-save-element').attr('status');

    if (btn == 1) {
        AddElement();
    }
    else {
        ComfirmEdit();
    }
}



function LoadAddForm()
{
   var obj ={
      ajax_action : 'product.loadAddID'
   };

   $.post(
      '/PS_App/Public/index.php',
      obj,
      function(data)
      {
         $('#GetID').html(data);
      },
      'html'
   );
}

function AddElement()
{

    var formData = new FormData($('form#form-save-element')[0]);
    $.ajax({
        url: '/PS_App/Public/index.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            if(data == 1)
            {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم حفظ  </strong> ... ',
                    message: '  بيانات المنتج '+ $('#product_name').val() + ' بنجــاح .'
                },{
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
                LoadEmp();
            }else
            {
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                },{
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

        }
    });

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
        success: function (data) {
            $('.table-responsive .main-table tbody').html(data);

        }
    });
}

function LoadEmp()
{
    var obj ={
        ajax_action : 'product.load',
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data)
        {
            $('.main-table tbody').html(data);
            $('.table-responsive').hide().delay(1000);
            $('.table-responsive').slideDown(1000);
        },
        'html'

    );
}

function EditElement(btn , e)
{
	e.preventDefault();
	LoadElementEdit(btn);
    $('#btn-save-element').attr('status',"2");
    $('#modal-add-element .title-top').html('<span class="content-title"> <i class="fa fa-list-alt"></i> المنتجات <i class="fa fa-chevron-left"></i> <h3>تعديل بيانات المنتج</h3> </span>');
	$('#add').modal('show',2000);
}

function LoadElementEdit(btn) {
    var obj ={
        ajax_action : 'product.LoadElementEdit',
		id : $(btn).attr('element_id')
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data)
        {
            var product = JSON.parse(data);
            $('#product_name').val(product.product_name);
            $('#product_dec').val(product.product_dec);
            $('#mini_stock').val(product.mini_stock);
            $('#category_id').val(product.category_id);
            $('#purchase_price').val(product.purchase_price);
            $('#sale_price').val(product.sale_price);
            $('#idElementID').val(product.id);
            $('#action').val("product.edit");
            LoadElementImg(product.id);
        },
        'html'

    );
}

function LoadElementImg(id) {
    var obj ={
        ajax_action : 'product.loadEmpImg',
        id : id
    };

    $.post(
        '/PS_App/Public/index.php',
        obj,
        function(data)
        {
            console.log(data);
            $('.thumb-preview').attr('src',data);
        },
        'html'

    );
}

function resetThumb(id,e)
{
    e.preventDefault();
    if ($('#btn-save-element').attr('status') == 1){
        LoadElementImg(0);

    }else{
        LoadElementImg($('#idElementID').val());
    }

    $('#avatar').val(null);


    $('.thumb-reset').hide();
}

function ComfirmEdit() {

    var formData = new FormData($('form#form-save-element')[0]);
    $.ajax({
        url: '/PS_App/Public/index.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            if(data == 1)
            {
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم تحديث  </strong> ... ',
                    message: '  بيانات المنتج '+ $('#product_name').val() + ' بنجــاح .'
                },{
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
                LoadEmp();
            }else
            {
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                },{
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

        }
    });
}

function DeleteElement(btn , e)
{
	e.preventDefault();
	$('#comfirm').modal('show',2000);
	$('#btn-delete').attr('element_id',$(btn).attr('element_id'));
}

function comfirmDelete(btn , e) {
    e.preventDefault();
    $('#comfirm').modal('hide');
	var obj ={
		ajax_action : 'product.delete',
		id : $(btn).attr('element_id')
	};

	$.post(
		'/PS_App/Public/index.php',
		obj,
		function(data)
		{
		    console.log(data);
			if(data == 1)
			{
                $.notify({
                    // options
                    icon: 'fa fa-check-circle',
                    title: '<strong> تم حذف  </strong> ... ',
                    message: '  بيانات المنتج رقم '+ $(btn).attr('element_id') + ' بنجــاح .'
                },{
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
                LoadEmp();
			}else
			{
                $.notify({
                    // options
                    icon: 'fa fa-exclamation-circle',
                    title: '<strong>عزراً </strong> ... ',
                    message: 'لقد واجهتنا بعض المشاكل يرجي المحاولة لاحقاً .'
                },{
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


