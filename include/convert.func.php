<?php
/*
	 
	This is NOT a freeware, use is subject to license.txt
*/
defined('IN_AIJIACMS') or exit('Access Denied');
function dconvert($str, $from = 'utf-8', $to = 'gb2312') {
	$from = str_replace('utf-8', 'utf8', $from);
	$to = str_replace('utf-8', 'utf8', $to);
	$tmp = file(AJ_ROOT.'/file/table/gb-unicode.table');
	if(!$tmp) return $str;
	$table = array();
	while(list($key, $value) = each($tmp)) {
		if($from == 'utf8') {
			$table[hexdec(substr($value, 7, 6))] = substr($value, 0, 6);
		} else {
			$table[hexdec(substr($value, 0, 6))] = substr($value, 7 , 6);
		}
	}
	unset($tmp);
	$dstr = '';
	if($from == 'utf8') {
		$len = strlen($str);
		$i = 0;
		while($i < $len) {
			$c = ord(substr( $str, $i++, 1 ));
			switch($c >> 4) {
				case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
					$dstr .= substr($str, $i-1, 1);
				break;
				case 12: case 13:
					$char2 = ord( substr($str, $i++, 1));
					$char3 = $table[(($c & 0x1F) << 6) | ($char2 & 0x3F)];
					$dstr .= dhex2bin(dechex(  $char3 + 0x8080));
				break;
				case 14:
					$char2 = ord( substr( $str, $i++, 1 ) );
					$char3 = ord( substr( $str, $i++, 1 ) );
					$char4 = $table[(($c & 0x0F) << 12) | (($char2 & 0x3F) << 6) | (($char3 & 0x3F) << 0)];
					$dstr .= dhex2bin(dechex($char4 + 0x8080));
				break;
			}
		}
	} else {
		while($str) {
			if(ord(substr($str, 0, 1)) > 127) {
				$utf8 = dch2utf8(hexdec($table[hexdec(bin2hex(substr($str,0,2)))-0x8080]));
				$dutf8 = strlen($utf8);
				for($i = 0; $i < $dutf8; $i += 3) {
					$dstr .= chr(substr($utf8, $i,3));
				}
				$str = substr($str, 2, strlen($str));
			} else {
				$dstr .= substr($str, 0, 1);
				$str = substr($str, 1, strlen($str));
			}
		}
	}
	unset($table);
	return $dstr;
}

function dhex2bin($hexdata) {
	$bindata = '';
	$dhexdata = strlen($hexdata);
	for($i = 0; $i < $dhexdata; $i += 2) {
		$bindata .= chr(hexdec(substr($hexdata, $i, 2)));
	}
	return $bindata;
}

function dch2utf8($c) {
	$str = '';
	if ($c < 0x80) {
		$str .= $c;
	} else if ($c < 0x800) {
		$str .= (0xC0 | $c>>6);
		$str .= (0x80 | $c & 0x3F);
	} else if ($c < 0x10000) {
		$str .= (0xE0 | $c>>12);
		$str .= (0x80 | $c>>6 & 0x3F);
		$str .= (0x80 | $c & 0x3F);
	} else if ($c < 0x200000) {
		$str .= (0xF0 | $c>>18);
		$str .= (0x80 | $c>>12 & 0x3F);
		$str .= (0x80 | $c>>6 & 0x3F);
		$str .= (0x80 | $c & 0x3F);
	}
	return $str;
}
?>