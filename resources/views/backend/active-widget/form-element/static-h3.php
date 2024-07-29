<?php
$DOMLabel->html($DOMLabel->html() ? $DOMLabel->get(0).': '.$DOM->value : $DOM->value);
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<h3><?=$DOMLabel->get(0)?></h3>
	<?if (isset($hint)):?>
		<div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
