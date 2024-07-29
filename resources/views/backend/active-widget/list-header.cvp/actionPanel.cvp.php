<?php
$renderListActionPanel = function()
{
	$LIST = $this->widgetOwner;
	
	if ($this->isTpl('actions'))
	{
        $actions = $LIST->groupActions();
		foreach ($actions as $k => $v)
		{
			$v->template('./'.$k, true);
            
            if ($this->isTpl('actions>custom>'.$k))
			{
				$this->tpl('actions>custom>'.$k)->html($v->render())->render();
			}
            else $this('actions>'.$k)?->html($v->render())->render();
		}
		$this('actions>custom')?->render();
        
        //
		$form = $LIST->form();
        $countFilter = count($LIST->filteredBy());
		if ($form?->filter?->count() && (count($LIST) || $countFilter))
		{
			if ($this->isTpl('actions>filter'))
			{
				$this('actions>filter')
                    ->active($countFilter ? '-active':'')
                    ->disabled($form->search?->value() == '' ? '':'disabled')
                    ->render();
			}
            
			if ($this->isTpl('search'))
			{
				$this('search')
					->searchValue((string)$form->search?->value())
					->searchActive($form->search?->value() != '' ? 'active' : '')
					// ->filterActive(count($LIST->filteredBy()) && $LIST->form()->search->value() == '' ? 'active' : '')
					->render();
			}
		}
		//
		
		$this('actions')->render();
	}
};
?>
<cvp render="renderListActionPanel">
    <div class="list-actions-panel">
      <div class="b-btnWrapper -top">
          <cvp:search widget />
          <cvp:actions widget />
      </div>
    </div>
    
</cvp>
