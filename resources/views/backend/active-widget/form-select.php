<?php
/**
 * @var \Kcms\Active\Form_Element $element Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var \Closure $domOption  Function which returns custom DOM option
 * @var array $choice  Assoc array of available checkboxes
 * @var array $emptyValue  Array of the first "empty" option in order ('title', 'value')
 * @var array $choiceItems  If choice made from Entity collection then it is an assoc array in order ['id' => Entity], otherwise is null
 * @var mixed $any  Any variable from widget's data container
 */

$choice = $emptyValue + $choice;
array_walk($choice, function(&$v, $k)use($DOM, $domOption){
	$v = x__($v);
	$DOM->append($domOption($k, $v));
});

$DOM->addClass($DOM->multiple() ? 'js-select-multiple' : 'js-select-single');
$DOM->autocomplete('off');
?>

<div class="b-formGroup -select <?=(isset($hint)?'-info':'')?>">
	<?if($DOMLabel->get(0)):?>
    <div class="b-formGroup__labelWrapper">
		<?=$DOMLabel->addClass('b-formGroup__label', ($DOM->required?'-required':''))->append(($DOM->required?DOM::Span('*'):''))?>
		<?if(!empty($tooltip)):?>
            <div class="b-tooltip js-tooltip t-right-top" title="<?=nl2br(htmlspecialchars($tooltip, ENT_COMPAT, \Kcms\Core\UTF8::CHARSET))?>"></div>
		<?endif;?>
    </div>
	<?endif;?>
	<div class="b-formGroup__fieldWrapper <?=(isset($icon)?'-icon -icon-'.$icon:'')?>">
		<?=$DOM?>
	</div>
	<?if (isset($hint)):?>
		<div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
