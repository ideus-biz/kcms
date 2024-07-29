<?php
/**
 * @var \Kcms\Active\Form_Element $element Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var array $choice
 * @var mixed $any  Any variable from widget's data container
 */

// t-right-top t-right-bottom t-left t-left-top t-left-bottom
?>
<?if($DOM->type === 'hidden'):?>
    <?=$DOM?>
<?else:
    $DOM->addClass('b-formGroup__input');
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
    <div class="b-formGroup__fieldWrapper <?=(isset($icon)?'-icon -icon-'.$icon:'')?>  <?=!empty($tooltip) ? 'l-tooltip':''?>">
		<?=$DOM?>
    </div>
	<?if (isset($hint)):?>
        <div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
<?endif;?>
