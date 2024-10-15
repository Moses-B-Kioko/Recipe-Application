(function($) {
	
	"use strict";
	
	//Hide Loading Box (Preloader)
	function handlePreloader() {
		if($('.loader-wrap').length){
			$('.loader-wrap').delay(1000).fadeOut(500);
		}
	}

	if ($(".preloader-close").length) {
        $(".preloader-close").on("click", function(){
            $('.loader-wrap').delay(200).fadeOut(500);
        })
    }

    if ($(".switch_btn_one").length) {
	    $(".search__toggler").on("click", function(){
	    	$(".search-field .switch_btn_one").addClass("active");
	    })     
	    $(".switch_btn_one .close-btn").on("click", function(){
	    	$(".search-field .switch_btn_one").removeClass("active");
	    }) 
    }
})(wnidow.JQuery);