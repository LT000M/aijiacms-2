/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
//var area_ditie_id;
//function load_area_ditie(areaid, id) {
//    area_ditie_id = id; area_ditie_areaid[id] = areaid;
//    $.post(AJPath, 'action=area_ditie&area_ditie_title='+area_ditie_title[id]+'&area_ditie_extend='+area_ditie_extend[id]+'&area_ditie_id='+area_ditie_id+'&areaid='+areaid, function(data) {
//        $('#areaid_ditie_'+area_ditie_id).val(area_ditie_areaid[area_ditie_id]);
//        if(data) $('#load_area_ditie_'+area_ditie_id).html(data);
//    });
//}
var area_ditie_id;
function load_area_ditie(areaid, id) {
    area_ditie_id = id; area_ditie_areaid[id] = areaid;
    $.post(AJPath, 'action=area_ditie&area_ditie_title='+area_ditie_title[id]+'&area_ditie_extend='+area_ditie_extend[id]+'&area_ditie_id='+area_ditie_id+'&areaid='+areaid, function(data) {
        $('#areaid_ditie_'+area_ditie_id).val(area_ditie_areaid[area_ditie_id]);
        if(data) $('#load_area_ditie_'+area_ditie_id).html(data);
    });
}

