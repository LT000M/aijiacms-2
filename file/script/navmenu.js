/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
var nav_id;
function load_navmenu(navid, id) {
	nav_id = id; navmenu_navid[id] = navid;
	$.post(AJPath, 'action=navmenu&navmenu_title='+navmenu_title[id]+'&navmenu_extend='+navmenu_extend[id]+'&navmenu_deep='+navmenu_deep[id]+'&nav_id='+nav_id+'&navid='+navid, function(data) {
		$('#navid_'+nav_id).val(navmenu_navid[nav_id]);
		if(data) $('#load_navmenu_'+nav_id).html(data);
	});
}