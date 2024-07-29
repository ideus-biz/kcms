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
	$DOM->tag('a')->href('#'.$widget->name().$widgetOwner->rowId())->addClass('b-table__deleteLink','btn-danger');
	$DOM->kcms('option-confirm', 'Warning! Are you really sure you need to delete this record permanently?');
}
else
{
	$DOM->addClass('b-btn', '-small', '-radius', 'bg-accent');
	$DOM->html(DOM::span($DOM->html())->addClass('b-btn__text'));
	$DOM->kcms('option-confirm', 'Warning! Are you really sure you need to delete selected record(s) permanently?');
}
$DOM->title('Be aware! This purges selected record(s) permanently. All relative data may be lost forever. Do it on your own responsibility.');
?>
<?=$DOM;