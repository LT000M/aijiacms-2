<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
$TYPE = array('全部主题', '最新发表', '最新回复', '精华主题', '热门主题');
$COLOR = array('FF0000'=>'红色', '0000FF'=>'蓝色', 'FF6600'=>'橙色');
$MANAGE = array('类型', '删除', '修改', '加精', '置顶', '高亮');
$L['fans_title'] = '圈子成员';
$L['join_pass_reason'] = '请填写加入理由';
$L['join_pass_max_reason'] = '加入原因最多500字';
$L['manage_has_del'] = '已经删除，无法查看';
$L['manage_cancel'] = '取消';
$L['manage_level'] = '精华';
$L['manage_ontop_1'] = '本圈';
$L['manage_ontop_2'] = '全局';
$L['group_pass_title'] = '请填写商圈名称';
$L['group_pass_thumb'] = '请上传商圈LOGO';
$L['group_pass_username'] = '请填写创建者';
$L['manage_msg_title'] = '您的{V0}“{V1}”被执行{V2}操作';
$L['manage_msg_content'] = '原文地址:<a href="{V0}" target="_blank">{V0}</a><br/>操作原因:{V1}<br/>操作人:{V2}<br/>如果您对此操作有异议，请及时与网站联系。';
$L['my_not_admin'] = '您没有此商圈管理权限';
$L['my_choose_group'] = '请选择商圈';
$L['my_choose_fans'] = '请选择粉丝';
$L['my_choose_post'] = '请选择帖子';
$L['my_choose_reply'] = '请选择回复';
$L['my_not_group'] = '商圈不存在';
$L['my_not_post'] = '帖子不存在';
$L['my_not_reply'] = '回复不存在';
$L['my_title'] = '我的帖子';
$L['my_fans_title'] = '粉丝管理';
$L['success_checked'] = '审核成功';
$L['success_cancel'] = '取消成功';
$L['success_reject'] = '拒绝成功';
$L['my_fans_fields'] = array('会员名', '申请理由');
$L['my_group_title'] = '我的商圈';
$L['my_join_title'] = '加入商圈';
$L['my_join_repeat'] = '您已经是该圈成员了';
$L['my_join_check'] = '您已经申请加入该圈了，请等待圈主审核';
$L['my_reply_title'] = '我的回复';
$L['my_reply_at'] = ' 发表于 ';
$L['my_manage_title'] = '商圈管理';
$L['my_manage_reason'] = '操作原因';
$L['my_manage_input_reason'] = '请填写操作原因';
$L['my_manage_not_level'] = '精华类型不存在';
$L['my_manage_post'] = '帖子管理';
$L['my_manage_reply'] = '回复管理';
$L['my_manage_type_post'] = '帖子';
$L['my_manage_type_reply'] = '回复';
$L['my_manage_type_edit'] = '修改';
$L['my_manage_type_del'] = '删除';
$L['my_manage_type_style'] = '高亮';
$L['my_manage_type_style_cancel'] = '取消高亮';
$L['my_manage_type_ontop'] = '置顶';
$L['my_manage_type_ontop_cancel'] = '取消置顶';
$L['my_manage_type_level'] = '加入精华';
$L['my_manage_type_level_cancel'] = '取消精华';
$L['post_title'] = '发表帖子';
$L['post_no_rights'] = '无发帖权限';
$L['post_too_many'] = '发帖数量超出限制';
$L['post_too_many_today'] = '今日发帖数量超出限制';
$L['post_msg_fee'] = '发帖需要收费，请切换到';
$L['post_msg_advance'] = '高级模式';
$L['post_success_edit'] = '帖子修改成功';
$L['post_success_del'] = '帖子删除成功';
$L['post_success_style'] = '高亮设置成功';
$L['post_cancel_style'] = '高亮取消成功';
$L['post_success_ontop'] = '置顶设置成功';
$L['post_cancel_ontop'] = '置顶取消成功';
$L['post_success_level'] = '精华设置成功';
$L['post_cancel_level'] = '精华取消成功';
$L['reply_success_edit'] = '回复修改成功';
$L['reply_success_del'] = '回复删除成功';
$L['reply_no_rights'] = '无回复权限';
$L['reply_too_many'] = '回复数量超出限制';
$L['reply_title'] = '发表回复';
$L['my_fields_post'] = array('模糊', '标题',  '会员名');
$L['my_fields_reply'] = array('内容', '会员名');
$L['my_fields_manage'] = array('主题/回复', '操作原因', '操作内容');
$L['msg_not_fans'] = '请先加入商圈';
?>