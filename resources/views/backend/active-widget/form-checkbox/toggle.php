<?php
/**
 * KCMS Active Form Widget Checkbox template
 *
 * Visualizes \Kcms\Active\Form_Element as form's HTML INPUT tag of type checkbox with or w/o LABEL tag.
 *
 * @category   KCMS Active Form Widget
 * @package    KCMS Active
 * @author     Andrey Potapov
 * @copyright     2010-2023 Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      X.2011
 * @version    3.2.2013.0607
 * @version    3.2.2016.1111
 * @version    3.2.2016.1220 - autocomplete = 'off' is added
 * @version    5.3.2022.1215 - DOM is used
 *
 * @var \Kcms\Active\Form_Element $element Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var mixed $any  Any variable from widget's data container
 */

$DOM->addClass('b-formGroup__checkboxToggle js-checkbox');
$DOM->autocomplete ??= 'off';
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<?if($DOMLabel->get(0) && isset($hint)):?>
        <div class="b-formGroup__labelWrapper">
		    <?=$DOMLabel->addClass('b-formGroup__label toggle')?>
            <?if(!empty($tooltip)):?>
                <div class="b-tooltip js-tooltip tooltip t-right-top" title="<?=nl2br(htmlspecialchars($tooltip, ENT_COMPAT, \Kcms\Core\UTF8::CHARSET))?>"></div>
            <?endif;?>
        </div>
	<?endif;?>
    <div class="b-formGroup__fieldWrapper -toggle">
		<?=$DOM?>
		<?if($DOMLabel->get(0) && isset($hint)):?>
            <label class="b-formGroup__checkboxToggleText" for="toggle">
                <?=x_lhtml($hint)?>
            </label>
        <?else:?>
            <label class="b-formGroup__checkboxToggleText" for="toggle">
                <?=($DOMLabel->get(0) ?: x_lhtml($hint))?>
            </label>
        <?endif;?>
    </div>
</div>
