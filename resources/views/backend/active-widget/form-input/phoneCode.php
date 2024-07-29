<?php
/**
 * @var \Kcms\Active\Form_Element $element Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var \Kcms\Active\Form_Element $phoneCode
 */

$DOM->addClass('b-formGroup__input');
$DOM->addClass('js-format-pattern');
$DOM->data('format-pattern', '[\d ()\+-]*');
$DOM->autocomplete('off');
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
    <?if($DOMLabel->get(0)):?>
		<?=$DOMLabel->addClass('b-formGroup__label', ($DOM->required?'-required':''))->append(($DOM->required?DOM::Span('*'):''))?>
    <?endif;?>
    <div class="b-formGroup__fieldWrapper -phone">
        <?$select = DOM::select($phoneCode->widget()->dom()->name)->addClass('js-select-single')->disabled($DOM->readonly())->autocomplete('off');?>
		<?foreach(KCMS::Message('phoneCodes') as $k => $v):?>
            <?$select->append(DOM::option(x_html($v['code'].' '.$v['title']))->value($v['code'])->data('code', $k)->selected($phoneCode->value()==$v['code']))?>
		<?endforeach;?>
        <?=$select?>
		<?=$DOM?>
    </div>
	<?if (isset($hint)):?>
        <div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
