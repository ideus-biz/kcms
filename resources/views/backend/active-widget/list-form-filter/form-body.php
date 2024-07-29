<?php
    $arr = \arr($form->listElementNames())->table(3, true, true);
?>
<?for ($i = 0, $n = count($arr); $i < $n; $i++):?>
    <div class="b-formGrid__row -triple">
		<?foreach ($arr[$i] as $v):?>
            <?=$form[$v]->render()?>
		<?endforeach;?>
    </div>
<?endfor;