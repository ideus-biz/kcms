<?php
/**
 * @var \Kcms\Active\Form_Element $element Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var array $choice
 * @var mixed $any  Any variable from widget's data container
 */

$DOM->addClass('b-formGroup__input');
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<?if($DOMLabel->get(0)):?>
		<?=$DOMLabel->addClass('b-formGroup__label')?>
	<?endif;?>
	<div class="b-formGroup__fieldWrapper <?=(isset($icon)?'-icon -icon-'.$icon:'')?>">
		<?=$DOM?>
	</div>
	<?if (isset($hint)):?>
		<div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
