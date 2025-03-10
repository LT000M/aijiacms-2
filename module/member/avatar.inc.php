<?php 
defined('IN_AIJIACMS') or exit('Access Denied');
login();
require AJ_ROOT.'/module/'.$module.'/common.inc.php';
require AJ_ROOT.'/include/post.func.php';
$avatar = useravatar($_userid, 'large', 0, 2);
switch($action) {
	case 'update':
		$t = $avatar ? 1 : 0;
		$db->query("UPDATE {$AJ_PRE}member SET avatar=$t WHERE userid=$_userid");
		dheader('?reload='.$AJ_TIME);
	break;
	case 'upload':
		if($_FILES) {
			if(!$_FILES['file']['size'] || !is_image($_FILES['file']['name'])) exit('{"error":1,"message":"Error FILE"}');
			require AJ_ROOT.'/include/upload.class.php';
			$ext = file_ext($_FILES['file']['name']);
			$name = 'avatar'.$_userid.'.'.$ext;
			$file = AJ_ROOT.'/file/temp/'.$name;
			if(is_file($file)) file_del($file);
			$upload = new upload($_FILES, 'file/temp/', $name, 'jpg|jpeg|gif|png');
			$upload->adduserid = false;
			if(!$upload->save()) exit('{"error":1,"message":"'.$upload->errmsg.'"}');
		} else {
			if(strpos($_DPOST['image'], 'data:image/png;base64,') === false) exit('{"error":1,"message":"Error IMAGE"}');
			$ext = 'png';
			$name = 'avatar'.$_userid.'.'.$ext;
			$file = AJ_ROOT.'/file/temp/'.$name;
			if(is_file($file)) file_del($file);
			$image = $_DPOST['image'];
			$image = cutstr($image, 'data:image/png;base64,');
			$image = base64_decode($image);
			file_put($file, $image);
		}
		$img_info = @getimagesize($file);
		$upload_mime = array('jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png');
		if(!$img_info || $img_info['mime'] != $upload_mime[$ext] || $img_info[0] < 128 || $img_info[1] < 128) file_del($file);
		$img_info or exit('{"error":1,"message":"'.$L['avatar_img_t'].'"}');
		$img_info['mime'] == $upload_mime[$ext] or exit('{"error":1,"message":"'.$L['avatar_img_t'].'"}');
		$img_info[0] >= 128 or exit('{"error":1,"message":"'.$L['avatar_img_w'].'"}');
		$img_info[1] >= 128 or exit('{"error":1,"message":"'.$L['avatar_img_h'].'"}');
		$ani = ($ext == 'gif' && strpos(file_get($file), chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0') !== false && $_FILES['file']['size'] < 200*1024) ? 1 : 0;
		$md5 = md5($_userid);
		$dir = AJ_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/'.$_userid;
		$img = array();
		$img[1] = $dir.'.jpg';
		$img[2] = $dir.'x48.jpg';
		$img[3] = $dir.'x20.jpg';
		$md5 = md5($_username);
		$dir = AJ_ROOT.'/file/avatar/'.substr($md5, 0, 2).'/'.substr($md5, 2, 2).'/_'.$_username;
		$img[4] = $dir.'.jpg';
		$img[5] = $dir.'x48.jpg';
		$img[6] = $dir.'x20.jpg';
		require AJ_ROOT.'/include/image.class.php';
		if(!$ani) {
			$image = new image($file);
			$image->thumb(128, 128);
		}
		file_copy($file, $img[1]);
		file_copy($file, $img[4]);
		if(!$ani) {
			$image = new image($file);
			$image->thumb(48, 48);
		}
		file_copy($file, $img[2]);
		file_copy($file, $img[5]);
		if(!$ani) {
			$image = new image($file);
			$image->thumb(20, 20);
		}
		file_copy($file, $img[3]);
		file_copy($file, $img[6]);
		file_del($file);
		if($AJ['ftp_remote'] && $AJ['remote_url']) {
			require AJ_ROOT.'/include/ftp.class.php';
			$ftp = new dftp($AJ['ftp_host'], $AJ['ftp_user'], $AJ['ftp_pass'], $AJ['ftp_port'], $AJ['ftp_path'], $AJ['ftp_pasv'], $AJ['ftp_ssl']);
			if($ftp->connected) {
				foreach($img as $i) {
					$t = explode("/file/", $i);
					$ftp->dftp_put('file/'.$t[1], $t[1]);
				}
			}
		}
		exit('{"error":0}');
	break;
	case 'delete':
		if($avatar) {
			$img = array();
			$img[1] = useravatar($_userid, 'large', 0, 2);
			$img[2] = useravatar($_userid, '', 0, 2);
			$img[3] = useravatar($_userid, 'small', 0, 2);
			$img[4] = useravatar($_username, 'large', 1, 2);
			$img[5] = useravatar($_username, '', 1, 2);
			$img[6] = useravatar($_username, 'small', 1, 2);
			foreach($img as $i) {
				file_del($i);
			}
			if($AJ['ftp_remote'] && $AJ['remote_url']) {
				require AJ_ROOT.'/include/ftp.class.php';
				$ftp = new dftp($AJ['ftp_host'], $AJ['ftp_user'], $AJ['ftp_pass'], $AJ['ftp_port'], $AJ['ftp_path'], $AJ['ftp_pasv'], $AJ['ftp_ssl']);

				if($ftp->connected) {
					foreach($img as $i) {
						$t = explode("/file/", $i);
						$ftp->dftp_delete($t[1]);
					}
				}
			}
		}
		$db->query("UPDATE {$AJ_PRE}member SET avatar=0 WHERE userid=$_userid");
		dmsg($L['avatar_delete'], '?reload='.$AJ_TIME);
	break;
	default:
		$head_title = $L['avatar_title'];	
	break;
}
if($AJ_PC) {
	//
} else {
	$foot = '';
}
include template('avatar', $module);
?>