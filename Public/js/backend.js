$(function()
   {

   		'use strict';

       // Trigger Nice Scroll Pluging

       $('html').niceScroll();

		// Caching The Scroll Top Element

		$('#btn-siderbar-collapse').click(function(){
			if ( $('#body').hasClass('has-mini-sidebar') )
				$('#body').removeClass('has-mini-sidebar');
			else
				$('#body').addClass('has-mini-sidebar');

		});


   		// Hide Placeholder On Form Focus

   		$('[placeholder]').focus(function(){

   				$(this).attr('data-text',$(this).attr('placeholder'));
   				$(this).attr('placeholder','');

   		}).blur(function()
   			{
   				$(this).attr('placeholder',$(this).attr('data-text'));
   			}
   		);

   		// Active NavSiderBar

	   $('.nav-item').click(function () {
		   $('.nav-item').removeClass('active-nav');
		   $(this).addClass('active-nav');
       });

	   // Header Btns SHow ON Mouse in .content-header


       // $('.content-header').hover(function () {
       //    $('.header-btns').css('display','block');
       // },function () {
       //     $('.header-btns').hide(1000);
       // });

       // $('.content-header').hover(function () {
		//    $('.header-btns').show(1000).delay(2000);
       // });
       //
       // $('.content-header').hover(function () {
		//    $('.header-btns').delay(1000).hide(1000);
       // });

       $('.content').append("<div style='clear: both'></div>")

       // Gelander .

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

   }
);

function newFunction() {
	$('#btn-siderbar-collapse').click(function () {
		if ($('#body').hasClass('has-mini-sidebar'))
			$('#body').removeClass('has-mini-sidebar');
		else
			$('#body').addClass('has-mini-sidebar');
	});
}


function myNavFunction(id) {
    $("#date-popover").hide();
    var nav = $("#" + id).data("navigation");
    var to = $("#" + id).data("to");
    console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
}
