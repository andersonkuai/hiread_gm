<?php foreach($mgqList as $row){?>
<li>
    <span><?=date("Y-m-d", $row->trade_time)?></span>
    <span><?=\common\enums\Balance::label($row->trade_type)?></span>
    <em class="<?=$row->retype?'increase':'decrease'?>"><?=$row->retype?'+':''?><?=sprintf('%.2f', $row->trade_num)?></em>
</li>
<?php }?>
