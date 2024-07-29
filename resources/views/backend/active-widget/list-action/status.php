<?php
/**
 * @var \Kcms\Active\DOM_Tag $DOM
 * @var \Kcms\Active\List_Widget_Action $widget
 * @var \Kcms\Active\ListWrapper $widgetOwner
 */

use Kcms\Active\DOM;
use Kcms\Active\List_ActionType;


if ($DOM->disabled) $DOM->removeClass('js-active-list-action')->style('color', 'darkgray');
if ($widget->type() == List_ActionType::ROW)
{
	$DOM->tag('a')->href('#'.$widget->name().$widgetOwner->rowId())->addClass('b-table__manageLink');
}
else
{
	$DOM->addClass('b-btn', '-small', '-radius', 'bg-secondary-1');
	$DOM->html(DOM::span($DOM->html())->addClass('b-btn__text'));
}
$DOM->title('Toggles selected records(s) activity');
?>
<?=$DOM;