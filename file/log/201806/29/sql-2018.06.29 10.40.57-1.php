<?php exit;?>
<sql>
	<time>2018-06-29 10:40:57</time>
	<ip>127.0.0.1</ip>
	<user>aijiacms</user>
	<php>/house/show.php</php>
	<querystring>&amp;at=&amp;itemid=1</querystring>
	<message>		<query>SELECT COUNT(*) AS num FROM aijiacms_newhouse_xiangce    where houseid=1 AND a.catid!=24 AND catid=23  LIMIT 0,1</query>
		<errno>0</errno>
		<error>Unknown column 'a.catid' in 'where clause'</error>
		<errmsg>MySQL Query Error</errmsg>
</message>
</sql>