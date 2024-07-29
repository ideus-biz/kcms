<?php
/**
 * KCMS Active Form Widget CKEditor template
 *
 * Visualizes \Kcms\Active\Form_Element as form's tINYmce widget with or w/o LABEL tag.
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
 * @version    5.3.2023.0220 - kcms-option-config moved to class
 *
 * @var \Kcms\Active\Form_Element $element Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var array $editorConfig
 * @var mixed $any  Any variable from widget's data container
 */

$DOM->addClass('b-formGroup__textarea');
!$DOM->rows && $DOM->rows(20);
?>
<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<?if($DOMLabel->get(0)):?>
		<?=$DOMLabel->addClass('b-formGroup__label', ($DOM->required?'-required':''))->append(($DOM->required?DOM::Span('*'):''))?>
	<?endif;?>
	<div class="b-formGroup__fieldWrapper -textarea <?=(isset($icon)?'-icon -icon-'.$icon:'')?>">
		<?=$DOM?>
	</div>
	<?if (isset($hint)):?>
		<div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
