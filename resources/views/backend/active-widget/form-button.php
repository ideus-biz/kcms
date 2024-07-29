<?php
/**
 * @see        \Kcms\Active\Form_Widget_Button
 * 
 * @var \Kcms\Active\DOM_Tag $dom  Button DOM
 * @var \Kcms\Active\Form $form  Form
 */

$DOM->addClass('b-btn -outline');
if (!$DOM->hasClass('bg-custom')) $DOM->addClass('bg-secondary-4');
?>
<?=$DOM->html(DOM::span($label)->addClass('b-btn__text'));?>
