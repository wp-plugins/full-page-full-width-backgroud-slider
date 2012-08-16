
jQuery(document).ready(function(){

	if(jQuery("#fwbslider_post_metas #fwb_disable").is(':checked')){
		jQuery('#fwbslider_post_metas  .fwbslider_disable').hide();
	}
	
	if(!jQuery("#fwbslider_post_metas #fwb_check").is(':checked')){
		jQuery('#fwbslider_post_metas  .fwbslider_table').hide();
	}
	

jQuery("#fwbslider_post_metas #fwb_check").click(function(){

	if(jQuery("#fwbslider_post_metas #fwb_check").is(':checked')){
		jQuery('#fwbslider_post_metas  .fwbslider_table').slideDown();
	}
	else{
		jQuery('#fwbslider_post_metas  .fwbslider_table').slideUp();
	}
});

jQuery("#fwbslider_post_metas #fwb_disable").click(function(){

	if(jQuery("#fwbslider_post_metas #fwb_disable").is(':checked')){
		jQuery('#fwbslider_post_metas  .fwbslider_disable').slideUp();
		jQuery("#fwbslider_post_metas #fwb_check").prop("checked", false);
	}
	else{
		jQuery('#fwbslider_post_metas  .fwbslider_disable').slideDown();
	}
});


});

