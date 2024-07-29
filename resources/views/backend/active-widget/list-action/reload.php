<?php
/**
 * @var \Kcms\Active\DOM_Tag $DOM
 * @var \Kcms\Active\List_Widget_Action $widget
 * @var \Kcms\Active\ListWrapper $widgetOwner
 */

use Kcms\Active\DOM;


if ($DOM->disabled) $DOM->removeClass('js-active-list-action')->style('color', 'darkgray');
$DOM->addClass('b-btn', '-small', '-radius', 'bg-secondary-2');
$DOM->html(DOM::span($DOM->html())->addClass('b-btn__text'));
?>
<?=$DOM;