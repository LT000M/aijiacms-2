<?php defined('IN_AIJIACMS') or exit('Access Denied');?><?php if(is_array($tags)) { foreach($tags as $i => $t) { ?><a href="<?php echo $MODULE[$moduleid]['linkurl'];?><?php echo rewrite('search.php?kw='.urlencode($t['word']));?>"<?php if($target) { ?> target="<?php echo $target;?>"<?php } ?>><?php echo $t['word'];?></a>&nbsp; <?php } } ?>