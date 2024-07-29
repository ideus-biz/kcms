<?php

$DOM->addClass('b-formGroup__input js-calendar');

$format = strtr($DOM->data('dateformat')?:I18n::Instance()->format('date'), ['d'=>'dd', 'j'=>'d', 'D'=>'D', 'l'=>'DD', 'n'=>'m', 'm'=>'mm', 'M'=>'M', 'F'=>'MM', 'Y'=>'yy', 'y'=>'y']);
$DOM->data('dateformat', $format);
?>
<div class="b-formGroup">
	<?if($DOMLabel->get(0)):?>
    <div class="b-formGroup__labelWrapper">
		<?=$DOMLabel->addClass('b-formGroup__label')?>
        <?if(!empty($tooltip)):?>
            <div class="b-tooltip js-tooltip t-right-top" title="<?=nl2br(htmlspecialchars($tooltip, ENT_COMPAT, \Kcms\Core\UTF8::CHARSET))?>"></div>
        <?endif;?>
    </div>
	<?endif;?>
    <?if(empty($range)):?>
        <div class="b-formGroup__fieldWrapper -icon -icon-calendar <?=!empty($tooltip) ? 'l-tooltip':''?>">
            <?=$DOM?>
        </div>
    <?else:?>
        <div class="b-formGroup__fieldWrapper -icon -icon-calendar">
            <?=$DOM->attr('name', $widgetOwner->htmlName().'[0]')->id($widgetOwner->htmlName('_').'_0')?>
        </div>
        <div class="b-formGroup__fieldWrapper -icon -icon-calendar">
			<?=$DOM->attr('name', $widgetOwner->htmlName().'[1]')->id($widgetOwner->htmlName('_').'_1')?>
        </div>
    <?endif;?>
</div>
