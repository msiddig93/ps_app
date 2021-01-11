function searchToggle(className , e){
   e.preventDefault();
   $('.' + className ).toggle();
}

function readUrl(input){

    if (input.files && input.files[0]) {
        file = input.files[0];
        reader = new FileReader();

        console.log(file.type.toString());
        if ( file.type.toString() == 'image/png' || file.type.toString() == 'image/jgp' || file.type.toString() == 'image/jpeg' ){
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                $('.thumb-preview').attr('src',e.target.result) ;
                $('.thumb-reset').show();
            }
        }else {
            $('#avatar').val(null);
            $.notify({
                // options
                icon: 'fa fa-warning',
                title: '<strong> عفواً </strong> ... ',
                message: ' إمتداد الملف غير مدعوم, المدعوم \'jpg, jpeg, png\' !'
            },{
                // settings
                type: "warning",
                allow_dismiss: false,
                newest_on_top: true,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "center"
                },
                offset: 20,
                spacing: 50,
                z_index: 9999,
                delay: 1000,
                timer: 2000,
                mouse_over: "pause",
                animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutLeft'
                }
            });
        }


    }
}

function TriggerInputFile(input,e)
{
    e.preventDefault();
    $('#' + input).hide();
    $('#' + input).click();
}

function resetThumb(img,e)
{
    e.preventDefault();

    $('.' + img).attr('src','img/emp/0.png');
    $('.thumb-reset').hide();
}


