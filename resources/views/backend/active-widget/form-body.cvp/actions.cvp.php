<?php
$render = function(){
	
	/*if (!empty($this->widgetOwner->widget()->body->data->hasViewMode) && !\Kcms\Core\Session_Layer::App()->editMode)
	{
		$this->isTpl('protected') && $this('protected')->url(\Kcms\Core\Route::Url('helper?action=editmode'))->render();
    }*/
	
	$buttons = $this->widgetOwner->wrapper()->actionButton();
	
	if ($this->isTpl('normal>button'))
	{
		foreach ($buttons as $k => $v)
		{
            if (empty($this->widgetOwner->widget()->body->data->hasViewMode) || \Kcms\Core\Session_Layer::App()->editMode || $v->dom()->tag() == 'a')
			{
                if ($k == 'cancel') $v->dom()->addClass('bg-custom bg-secondary-2');
                elseif ($k == 'delete') $v->dom()->addClass('bg-custom bg-accent');
                
                /*if ($this->widgetOwner->isReadonly() && $v->isSubmit())
				{
                    $v->dom()->disabled(true);
                }*/
                
				$this('normal>button')->button($v->render())
					->render();
			}
		}
	}
	
	$this('normal')->render();
};
?>
<div class="b-styleGuide__btnList">
    <cvp render="render">
        <cvp:normal>
            <cvp:button>$button</cvp:button>
        </cvp:normal>
    </cvp>
</div>
