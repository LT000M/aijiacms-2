/*
	 
	This is NOT a freeware, laibincn is subject to license.txt
*/
function show_wenfang() {
	if($('#wenfang_main').html().toLowerCase().indexOf('<div>')!=-1) $('#wenfang_main').html('<if'+'rame src="'+DTPath+'api/wenfang.php?mid='+module_id+'&itemid='+item_id+'" name="aijiacms_wenfang" id="aijia'+'cms_wenfang" style="width:100%;height:330px;" scrolling="no" frameborder="0"></if'+'rame>');
}
$(function(){
	var cmh2 = $(window).height();
	var cmh1 = $('#wenfang_count').offset().top;
	if(cmh1 < cmh2) {
		show_wenfang();
	} else {
		$(window).bind("scroll.wenfang", function() {
			if($(document).scrollTop() + cmh2 >= cmh1) {
				show_wenfang();
				$(window).unbind("scroll.wenfang");
			}
		});
	}
	$('#wenfang_div').mouseover(function() {
		show_wenfang();
	});
});