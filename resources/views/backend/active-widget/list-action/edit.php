<?php
/**
 * @var \Kcms\Active\DOM_Tag $DOM
 * @var \Kcms\Active\List_Widget_Action $widget
 * @var \Kcms\Active\ListWrapper $widgetOwner
 */

use Kcms\Active\DOM;


if ($DOM->disabled) $DOM->removeClass('js-active-list-action')->style('color', 'darkgray');
$DOM->tag('a')->href($widget->target())->addClass('b-table__manageLink','btn-view');
$DOM->kcms('assoc-object', '.js-active-list-edit-form');
?>
<?=$DOM;