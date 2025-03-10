<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('AJ_ADMIN') or exit('Access Denied');
$menus = array (
    array('添加任务', '?file='.$file.'&action=add'),
    array('计划任务', '?file='.$file),
);
$do = new cron();
switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			$type = $title = $name = $run = $hour = $mint = $status = $note = $n1 = $n2 = $n3 = $v1 = $v2 = $v3 = '';
			$minute = 30;
			include tpl('cron_edit');
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		$r = $do->get_one();
		$r or msg('任务不存在');
		if($r['type']) msg('内置任务不可修改');
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($r);
			$minute = 0;
			$run = 1;			
			if(strpos($schedule, ',') !== false) {
				list($hour, $mint) = explode(',', $schedule);
			} else {
				$minute = $schedule;
				$run = 0;
			}
			include tpl('cron_edit');
		}
	break;
	case 'delete':
		$itemid or msg();
		$do->itemid = $itemid;
		$r = $do->get_one();
		$r or msg('任务不存在');
		if($r['type'] || $itemid < 100) msg('内置任务不可删除');
		$do->delete();
		dmsg('删除成功', $forward);
	break;
	case 'run':
		$itemid or msg();
		$do->itemid = $itemid;
		$cron = $do->get_one();
		$cron or msg('任务不存在');
		include AJ_ROOT.'/api/cron/'.$cron['name'].'.inc.php';
		$nexttime = $do->nexttime($cron['schedule'], $AJ_TIME);
		$db->query("UPDATE {$AJ_PRE}cron SET lasttime=$AJ_TIME,nexttime=$nexttime WHERE itemid=$itemid");
		dmsg('运行成功', $forward);
	break;
	default:
		$sfields = array('按条件', '名称', '文件名', '时间表', '备注');
		$dfields = array('title', 'title', 'name', 'schedule', 'note');
		isset($fields) && isset($dfields[$fields]) or $fields = 0;
		$sorder  = array('结果排序方式', '上次运行降序', '上次运行升序', '下次运行降序', '下次运行升序', '任务文件降序', '任务文件升序');
		$dorder  = array('itemid DESC', 'lasttime DESC', 'lasttime ASC', 'nexttime DESC', 'nexttime ASC', 'name DESC', 'name ASC');
		isset($order) && isset($dorder[$order]) or $order = 0;

		$fields_select = dselect($sfields, 'fields', '', $fields);
		$order_select  = dselect($sorder, 'order', '', $order);

		$condition = '1';
		if($keyword) $condition .= match_kw($dfields[$fields], $keyword);
		$lists = $do->get_list($condition, $dorder[$order]);
		include tpl('cron');
	break;
}

class cron {
	var $itemid;
	var $table;
	var $errmsg = errmsg;

    function __construct() {
		$this->table = AJ_PRE.'cron';
    }

    function cron() {
		$this->__construct();
    }

	function pass($post) {
		if(!is_array($post)) return false;
		if(!$post['title']) return $this->_('请填写任务名称');
		if(!check_name($post['name']) || !is_file(AJ_ROOT.'/api/cron/'.$post['name'].'.inc.php')) return $this->_('请选择脚本文件');
		if($post['run']) {
			$hour = intval($post['hour']);
			if($hour < 0 || $hour > 23) return $this->_('小时必须为0-23');
			$mint = intval($post['mint']);
			if($mint < 0 || $hour > 59) return $this->_('分钟必须为0-59');
		} else {
			$minute = intval($post['minute']);
			if($minute < 1) return $this->_('间隔时间至少为1分钟');
		}
		return true;
	}

	function set($post) {
		if($post['run']) {
			$post['schedule'] = intval($post['hour']).','.intval($post['mint']);
		} else {
			$post['schedule'] = intval($post['minute']);
		}
		unset($post['run'], $post['hour'],$post['mint'],  $post['minute']);
		$post['status'] = $post['status'] ? 1 : 0;
		return $post;
	}

	function get_one() {
        return DB::get_one("SELECT * FROM {$this->table} WHERE itemid='$this->itemid'");
	}

	function get_list($condition = '', $order = 'itemid ASC') {
		global $MOD, $pages, $page, $pagesize, $offset, $sum;
		if($page > 1 && $sum) {
			$items = $sum;
		} else {
			$r = DB::get_one("SELECT COUNT(*) AS num FROM {$this->table} WHERE $condition");
			$items = $r['num'];
		}
		$pages = pages($items, $page, $pagesize);	
		$lists = array();
		$result = DB::query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = DB::fetch_array($result)) {
			$r['lasttime'] = $r['lasttime'] ? timetodate($r['lasttime'], 6) : 'N/A';
			$r['nexttime'] = $r['nexttime'] ? timetodate($r['nexttime'], 6) : 'N/A';
			$r['text'] = $this->time2text($r['schedule']);
			$lists[] = $r;
		}
		return $lists;
	}

	function add($post) {
		$post = $this->set($post);
		$sqlk = $sqlv = '';
		foreach($post as $k=>$v) {
			$sqlk .= ','.$k; $sqlv .= ",'$v'";
		}
        $sqlk = substr($sqlk, 1);
        $sqlv = substr($sqlv, 1);
		DB::query("INSERT INTO {$this->table} ($sqlk) VALUES ($sqlv)");
		return $this->itemid;
	}

	function edit($post) {
		$post = $this->set($post);
		$sql = '';
		foreach($post as $k=>$v) {
			$sql .= ",$k='$v'";
		}
        $sql = substr($sql, 1);
	    DB::query("UPDATE {$this->table} SET $sql WHERE itemid=$this->itemid");
		return true;
	}

	function delete() {
		DB::query("DELETE FROM {$this->table} WHERE itemid=$this->itemid");
	}

	function nexttime($schedule, $time) {
		if(strpos($schedule, ',') !== false) {
			list($h, $m) = explode(',', $schedule);
			$t = datetotime(timetodate($time, 3).' '.($h < 10 ? '0'.$h : $h).':'.($m < 10 ? '0'.$m : $m).':00');
			return $t > $time ? $t : $t + 86400;
		} else {
			$m = intval($schedule);
			return $time + ($m ? $m : 1800)*60;
		}
	}

	function time2text($schedule) {
		if(strpos($schedule, ',') !== false) {
			list($h, $m) = explode(',', $schedule);
			if($h < 10) $h = '0'.$h;
			if($m < 10) $m = '0'.$m;
			return '每天'.$h.':'.$m;
		} else {
			$m = intval($schedule);
			return '每'.$m.'分钟';
		}
		list($hour, $minute) = explode(',', $schedule);
	}

	function _($e) {
		$this->errmsg = $e;
		return false;
	}
}
?>