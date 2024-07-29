<?php
$DOM->addClass('b-formGroup__textarea');
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<?if($DOMLabel->get(0)):?>
    <div class="b-formGroup__labelWrapper">
		<?=$DOMLabel->addClass('b-formGroup__label', ($DOM->required?'-required':''))->append(($DOM->required?DOM::Span('*'):''))?>
		<?if(!empty($tooltip)):?>
            <div class="b-tooltip js-tooltip t-right-top" title="<?=nl2br(htmlspecialchars($tooltip, ENT_COMPAT, \Kcms\Core\UTF8::CHARSET))?>"></div>
		<?endif;?>
    </div>
	<?endif;?>
	<div class="b-formGroup__fieldWrapper -textarea <?=(isset($icon)?'-icon -icon-'.$icon:'')?>">
		<?=$DOM?>
	</div>
	<?if (isset($hint)):?>
		<div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
