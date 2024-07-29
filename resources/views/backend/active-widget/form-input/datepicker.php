<?php
$DOM->addClass('b-formGroup__input');
if (!empty($isMultiDates))
{
    $DOM->addClass('js-calendarMultiple');
    
    $dt = $DOM->data('min-date');
    if ($dt !== false && !is_numeric($dt))
	{
        $dt = \Kcms\Core\Date::From($dt)->interval(time());
		$DOM->data('min-date', $dt);
    }
    
    $dt = $DOM->data('max-date');
    if ($dt !== false && !is_numeric($dt))
	{
        $dt = \Kcms\Core\Date::From($dt)->interval(time());
		$DOM->data('max-date', $dt);
    }
}
else $DOM->addClass('js-calendar');

$format = strtr($DOM->data('dateformat')?:I18n::Instance()->format('date'), ['d'=>'dd', 'j'=>'d', 'D'=>'D', 'l'=>'DD', 'n'=>'m', 'm'=>'mm', 'M'=>'M', 'F'=>'MM', 'Y'=>'yy', 'y'=>'y']);
$DOM->data('dateformat', $format);
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
    <div class="b-formGroup__fieldWrapper -icon -icon-calendar <?=!empty($tooltip) ? 'l-tooltip':''?>">
        <?=$DOM?>
    </div>
	<?if (isset($hint)):?>
        <div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
