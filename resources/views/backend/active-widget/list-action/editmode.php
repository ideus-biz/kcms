<?php
/**
 * @var \Kcms\Active\DOM_Tag $DOM
 * @var \Kcms\Active\List_Widget_Action $widget
 * @var \Kcms\Active\ListWrapper $widgetOwner
 */

use Kcms\Active\DOM;


// $DOM->kcms('role', 'active-link');
// $DOM->kcms('assoc-object', 'ActiveList');

// $DOM->removeClass('js-active-list-action');
$DOM->addClass('b-btn', '-small', '-radius', 'bg-secondary-2');
$DOM->html(DOM::span($DOM->html())->addClass('b-btn__text'));
if ($DOM->disabled) $DOM->style('color', 'darkgray');
$DOM->title('Turns on extended tools to manage records in the list for a limited time period.');
?>
<?=$DOM;