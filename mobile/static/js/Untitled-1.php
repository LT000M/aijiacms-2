rewrite ^/(.*)\.(asp|aspx|asa|asax|dll|jsp|cgi|fcgi|pl)(.*)$ /404.php last;
rewrite ^/(.*)/file/(.*)\.php(.*)$ /404.php last;
rewrite ^/(.*)-htm-(.*)$ /$1.php?$2 last;
rewrite ^/(.*)/show-([0-9]+)([\-])?([0-9]+)?\.html$ /$1/show.php?itemid=$2&page=$4 last;
rewrite ^/(.*)/list-([0-9]+)([\-])?([0-9]+)?\.html$ /$1/list.php?catid=$2&page=$4 last;
rewrite ^/(.*)/show/([0-9]+)/([0-9]+)?([/])?$ /$1/show.php?itemid=$2&page=$3 last;
rewrite ^/(.*)/list/([0-9]+)/([0-9]+)?([/])?$ /$1/list.php?catid=$2&page=$3 last;
rewrite ^/(.*)/([A-za-z0-9_\-]+)-c([0-9]+)-([0-9]+)\.html$ /$1/list.php?catid=$3&page=$4 last;
rewrite ^/(.*)/([0-9]+)-([0-9]+)-([0-9]+)-([0-9]+)\.html$ /$1/index.php?moduleid=$2&catid=$3&itemid=$4&page=$5 last;
rewrite ^/(.*)/m([0-9]+)(\-q)([0-9]+)(\-l)([0-9]+)(\-j)([0-9]+)(\-t)([0-9]+)(\-o)([a-z]+)-p([0-9]+)\.html$ /$1/index.php?moduleid=$2&areaid=$3&catid=$4&price=$5&lpts=$6&ord=$7&page=$8 last;
#rewrite ^/(.*)/m([0-9]+)-q([0-9]+)-l([0-9]+)-j([0-9]+)-t([0-9]+)-o([0-9]+)-p([0-9]+)\.html$ /$1/index.php?moduleid=$2&areaid=$3&catid=$4&price=$5&lpts=$6&ord=$7&page=$8 last;
#rewrite ^/(.*)/m([0-9]+)q([0-9]+)l([0-9]+)j([0-9]+)t([0-9]+)o([0-9]+)p([0-9]+)\.html$ /$1/index.php?moduleid=$2&areaid=$3&catid=$4&price=$5&lpts=$6&ord=$7&page=$8 last;
#rewrite ^/(.*)/m([0-9]+)l([0-9]+)q([0-9]+)j([0-9]+)t([0-9]+)p([0-9]+)\.html$ /$1/index.php?moduleid=$2&catid=$3&areaid=$4&price=$5&lpts=$6&ord=$7 last;
rewrite ^/(.*)/([a-z]+)/(.*)\.shtml$ /$1/$2/index.php?rewrite=$3 last;
rewrite ^/(com)/([a-z0-9_\-]+)/([a-z]+)/(.*)\.html$ /index.php?homepage=$2&file=$3&rewrite=$4 last;
rewrite ^/(com)/([a-z0-9_\-]+)/([a-z]+)([/])?$ /index.php?homepage=$2&file=$3 last;
rewrite ^/(com)/([a-z0-9_\-]+)([/])?$ /index.php?homepage=$2 last;
rewrite ^/(house)/list-(r|b|t|p|f|l|o|h|n|g|j|e)([0-9A-Z_]+)\.html?$	/$1/list.php?&$2=$3  last;
rewrite ^/(house)/list-r([0-9]+)-t([0-9]+)-p([0-9]+)-k(.*)\.html?$	/$1/list.php?&r=$2&t=$3&p=$4&k=$5  last;
rewrite ^/(house)/map.html?$	/map/newhouse.php  last;
rewrite ^/(house)/([0-9]+)/?$ /$1/show.php?&at=$3&itemid=$2  last;
rewrite ^/(house)/([0-9]+)/index\.html?$ /$1/show.php?&at=$3&itemid=$2  last;
rewrite ^/(house)/([0-9]+)/wenfang-g([0-9]+)\.html?$ /extend/wenfang.php?mid=6&itemid=$1&page=$2 last;
rewrite ^/(house)/([0-9]+)/(xinxi|huxing|jiage|xiangce|wenfang|peitao|zixun|dianping|pic)\.html?$ /$1/show.php?&at=$3&itemid=$2   last;
rewrite ^/(.*)/p([0-9]+)-h([0-9]+)\.html?$ /$1/show.php?itemid=$2&houseid=$3 last;
rewrite ^/(house)/([0-9]+)/xiangce-c([0-9]+)\.html?$ /$1/show.php?&at=xiangce&itemid=$2&catids=$3 last;
rewrite ^/(house)/baojia\.html?$	 /$1/baojia.php last;
#经纪人规则
rewrite ^/(broker)/index\.html$	/$1/index.php last;
rewrite ^/(broker)/list-(r|b|t|p|f|l|o|h|n|g|c|y|e|m|u|i)([0-9_]+)\.html?$	/broker/index.php?&$2=$3 last;	
rewrite ^/(broker)/list-(.*)\.html?$	/$1/index.php?&param=$2  last;

rewrite ^/(fenxiao)/list-(r|b|t|p|f|l|o|h|n|g|c|y|e|m|u|i)([0-9_]+)\.html?$	/fenxiao/index.php?&$2=$3 last;	
rewrite ^/(fenxiao)/d-([0-9]+)\.html?$	/$1/detail.php?&itemid=$2  last;
#二手房规则
rewrite ^/(sale)/map\.html?$	/map/index.php last;
rewrite ^/(rent)/map\.html?$	/map/rent.php last;
rewrite ^/(map)/rent\.html?$	/map/rent.php last;
rewrite ^/(map)/sale\.html?$	/map/index.php last;
rewrite ^/(map)/house\.html?$	/map/newhouse.php last;

rewrite ^/(.*)/list\.html$	/$1/list.php last;
rewrite ^/(.*)/list-([a-z]+)([0-9_]+)\.html?$	/$1/list.php?&$2=$3 last;	
rewrite ^/(.*)/list-k(.*)\.html?$	/$1/list.php?&k=$2 last;
rewrite ^/(.*)/list-(.*)\.html?$	/$1/list.php?&param=$2  last;
rewrite ^/(.*)/pk/(.+)?$ /$1/compare.php?&itemid=$2 last;
#小区规则
rewrite ^/(community)/([0-9]+)/?$ /$1/show.php?&at=$3&itemid=$2 last;
rewrite ^/(community)/([0-9]+)/index\.html?$ /$1/show.php?&at=$3&itemid=$2 last;
rewrite ^/(community)/([0-9]+)/(sale|rent|price|map)\.html?$ /$1/show.php?&at=$3&itemid=$2  last;
rewrite ^/(community)/([0-9]+)/(sale|rent)-(p|c|i|u|h|n|e|m|g)([0-9_]+)\.html?$ /$1/show.php?&at=$3&itemid=$2&$4=$5  last;
rewrite ^/(community)/([0-9]+)/(sale|rent)-(.*)\.html?$	/$1/show.php?&at=$3&itemid=$2&param=$4  last;
rewrite ^/(.*)/search\.html$ /$1/search.php last;
rewrite ^/(.*)/search-k([^/-]+)\.html$	/$1/search.php?&kw=$2 last;
rewrite ^/(.*)/search-([^/-]+)-p([0-9]+)\.html$	/$1/search.php&kw=$2&page=$3  last;

rewrite ^/(.*)/(.*)\.htm$ /$1/404.php last;
