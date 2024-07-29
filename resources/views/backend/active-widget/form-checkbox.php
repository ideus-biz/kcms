<?php

$DOM->addClass('b-formGroup__checkbox js-checkbox');
$DOM->autocomplete('off');
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
    <div class="b-formGroup__smallRow">
        <div class="b-formGroup__fieldWrapper -checkbox">
            <?=$DOM?>
			<?if($DOMLabel->get(0)):?>
            <div class="b-formGroup__labelWrapper">
                <?=$DOMLabel->addClass('b-formGroup__checkboxText')?>
                <?if(!empty($tooltip)):?>
                    <div class="b-tooltip js-tooltip t-right-top" title="<?=nl2br(htmlspecialchars($tooltip, ENT_COMPAT, \Kcms\Core\UTF8::CHARSET))?>"></div>
                <?endif;?>
            </div>
			<?endif;?>
        </div>
    </div>
	<?if (isset($hint)):?>
        <div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
