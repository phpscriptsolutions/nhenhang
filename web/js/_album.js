$(document).ready(function() {
	var beforesend_album_vn = function(){
		//$("#box_album_vn").html(ajax_loading_content);
        $("#box_album_vn").prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
	}
	var success_album_vn = function(html){
		$("#box_album_vn").html(html);
	}
	var beforesend_album_aumy = function(){
		//$("#box_album_aumy").html(ajax_loading_content);
		$("#box_album_aumy").prepend('<div class=\"ovelay-loading-face\">'+ajax_loading_content+'</div>');
	}
	var success_album_aumy = function(html){
		$("#box_album_aumy").html(html);
	}
	var beforesend_album_chaua = function(){
		$("#box_album_chaua").html(ajax_loading_content);
	}
	var success_album_chaua = function(html){
		$("#box_album_chaua").html(html);
	}
	$(".load_album_hot_by_district").live("click",function(){
		var district = 'VN';
		if ($(this).hasClass("VN") ) {
			district = 'VN'; 		
		} else if ($(this).hasClass("AUMY") ) {
			district = 'AUMY'; 
		} else if ($(this).hasClass("CHAUA") ) {
			district = 'CHAUA'; 
		}
		
		var data_album = {'action':'albumByDistrict','_type':'hot', '_district': district};		
		if (district == 'VN') {
			ajax_load(ajax_url,data_album, beforesend_album_vn,success_album_vn);
		} else if (district == 'AUMY') {
			ajax_load(ajax_url,data_album, beforesend_album_aumy,success_album_aumy);
		}else if (district == 'CHAUA') {
				ajax_load(ajax_url,data_album, beforesend_album_chaua,success_album_chaua);
		}
	})
	$(".load_album_new_by_district").live("click",function(){
		var district = 'VN';
		if ($(this).hasClass("VN") ) {
			district = 'VN'; 		
		} else if ($(this).hasClass("AUMY") ) {
			district = 'AUMY'; 
		} else if ($(this).hasClass("CHAUA") ) {
			district = 'CHAUA'; 
		}
		
		var data_album = {'action':'albumByDistrict','_type':'new', '_district':district};
		if (district == 'VN') {
			ajax_load(ajax_url,data_album, beforesend_album_vn,success_album_vn);
		} else if (district == 'AUMY') {
			ajax_load(ajax_url,data_album, beforesend_album_aumy,success_album_aumy);
		}else if (district == 'CHAUA') {
				ajax_load(ajax_url,data_album, beforesend_album_chaua,success_album_chaua);
		}
	})
	
	
	/*Load bang xep hang*/
	var data_bxh = {'action':'chartByType','_type':'album', '_district': 'VN'};
	var beforesend_bxh = function(){
		$("#box_chart_by_type").html(ajax_loading_content);
	}
	var success_bxh = function(html){
		$("#box_chart_by_type").html(html);
	}
	ajax_load(ajax_url,data_bxh, beforesend_bxh, success_bxh);

	$(".head_line_chart_by_type").live("click",function(){
		$(".head_line_chart_by_type").removeClass("active");
		$(this).addClass("active");
		district = $(this).attr("rel");
		var data_bxh = {'action':'chartByType','_type':'album', '_district':district};
		ajax_load(ajax_url,data_bxh, beforesend_bxh, success_bxh);
	});
})
