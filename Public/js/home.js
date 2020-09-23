$(function(){
   	'use strict';

    // Active NavSiderBar

    //$('.nav-item').removeClass('active-nav');
    $('.home').addClass('active-nav');

   	var myLanguage = {
   		errorTitle : 'عزراً هنالك أخطاء !'
   	};

   	 $.validate({
   		form:'#form-user-login',
   		modules : 'file',
   		language : myLanguage,
   		validateOnBlur : true,
   		errorMessagePosition : 'left',
   		onError : function(){
   			// alert('Error');
   		},
   		onSuccess : function(){
   			// alert('Success')
   		}
   	});

    $("#date-popover").popover({html: true, trigger: "manual"});
    $("#date-popover").hide();
    $("#date-popover").click(function (e) {
        $(this).hide();
    });

    $("#my-calendar").zabuto_calendar({
        action: function () {
            return myDateFunction(this.id, false);
        },
        action_nav: function () {
            return myNavFunction(this.id);
        },
        ajax: {
            url: "#",
            modal: true
        },
        legend: [
            {type: "text", label: "Special event", badge: "00"},
            {type: "block", label: "Regular event", }
        ]
    });

});

function myNavFunction(id) {
    $("#date-popover").hide();
    var nav = $("#" + id).data("navigation");
    var to = $("#" + id).data("to");
    console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
}


