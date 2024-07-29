<?php
$DOMLabel->html($DOMLabel->html() ? $DOMLabel->get(0).': '.$DOM->value : $DOM->value);
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<?=$DOMLabel->addClass('b-formGroup__label')?>
	<?if (isset($hint)):?>
		<div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
