<?
/**
 * Active List header widget
 * 
 * @version 3.2.2016.1213
 * @version 3.2.2016.1221 - fix filter button
 * @version 3.2.2017.0208 - new UI
 * @version 3.2.2017.0210 - edit in popup context is added
 * @version 3.2.2017.0403 - UI update
 * @version 3.2.2017.0530 - attr for filter form name is changed
 * @version 3.2.2018.0531 - update
 * @version 3.2.2018.0627 - add and edit form are separated
 * @version 3.2.2018.0820 - text fix
 * @version 3.3.2018.1029 - popups class fix
 * @version 3.3.2018.1220 - security check is added
 * @version 5.3.2022.1214 - split by widgets
 * @version 5.3.2023.0131 - reset action added
 * @version 5.3.2023.0411 - refactoring
 * @version 5.5.2023.1101
 */

$renderer = function() {
	$LIST = $this->widgetOwner;
	
    $this->renderIf('actionPanel');
    $this->renderIf('filterPanel');
    $this->renderIf('notifications');
    $this->renderIf('columns');
    
	//
	if (!empty($LIST->widget()->addForm?->data->usePopup))
	{
		if ($this->isTpl('popupAddForm'))
		{
			$this('popupAddForm')
				->title(x_lhtml($LIST->widget()->addForm->data->title))
				->render();
		}
	}
	if (!empty($LIST->widget()->editForm?->data->usePopup))
	{
		if ($this->isTpl('popupEditForm'))
		{
			$this('popupEditForm')
				->title(x_lhtml($LIST->widget()->editForm->data->title))
				->render();
		}
	}
};
?>

<cvp render="renderer">

    <!-- Modal-->
    <cvp:popupAddForm widget/>
    <cvp:popupEditForm widget/>
    <!-- /Modal -->
    
    <!--Action panel-->
	<cvp:actionPanel widget />

    <!--Filter-->
    <cvp:filterPanel widget />

    <div class="b-table <?=!empty($isComplexTable)?'-hidden-row':''?> <?=$tableCss?:''?>">
        <table class="b-table__table">
            <thead>
            <cvp:columns widget />
            <cvp:notifications widget />
            </thead>
</cvp>
