<?
/**
 * @version 3.2.2016.1213
 * @version 3.2.2017.0208 - new UI
 * @version 3.2.2017.0210 - actions appearance updates ; edit in popup context is added
 * @version 3.2.2017.0403 - UI update
 * @version 3.2.2017.0512 - update
 * @version 3.2.2018.0531 - update
 * @version 5.3.2022.1214 - split by widgets
 * @version 5.3.2023.0411 - refactoring
 * @version 5.3.2023.0623
 * @version 5.5.2023.1101
 */

use Kcms\Active\List_ActionType;
use Kcms\Core\Arr;
use Kcms\Core\Session_Layer;


$renderListBody ??= function(){
	$LIST = $this->widgetOwner;
	// Get selected rows
	$selection = $LIST->selection();
	
	if (count($LIST))
	{
		for ($i = 0; $i < count($LIST); $i++)
		{
			$actions = $LIST[$i]->rowActions();
			
            // Checkbox
			if (count($actions) && $this->isTpl('row>checkbox'))
			{
				// $arr = Arr::Cleanup($LIST->groupActions(), fn($v) => ($v->type() != List_ActionType::GLOBAL));
				if (!isset(Session_Layer::App()->editMode) || Session_Layer::App()->editMode)
				{
                    if ($LIST->groupActions()->cleanup(fn($v) => ($v->type() != List_ActionType::GLOBAL))->count())
					{
						$this('row>checkbox')
							->number($LIST[$i]->rowNumber())
							->checked(in_array($LIST[$i]->rowId(), $selection) ? 'checked' : '')
							->style('')
							->render();
					}
				}
			}
            
			// Cells. Iterate through visible columns
			$this('row')->style('')
                ->class($this->hasRemovedRows ? ($LIST[$i]->isRemoved->value() ? 'b-table__rowDeleted':'') : '');
			foreach ($LIST->columns() as $name)
			{
				$cell = $LIST[$i]->$name;
                $this('row>cell')
                    ->name($name)
                    ->value($cell->render())
                    ->colspan($cell->widget()->data->colspan??'')
                    ->style('')
                    ->render();
			}
			
			//
			if (!empty($actions))
			{
				foreach ($actions as $k => $v)
				{
					$v->template('./'.$k, true);
                    
					if ($this->isTpl("row>actionGroup>actions>custom>$k"))
					{
						$this->tpl("row>actionGroup>actions>custom>$k")->html($v->render())->render();
                    }
					else $this("row>actionGroup>actions>$k")?->html($v->render())->render();
				}
				
				$this('row>actionGroup>actions>custom')?->render();
				$this('row>actionGroup>actions')?->style('')->render();
			}
            else $this('row>actionGroup>noActions')?->style('')->render();
            
            $this('row>actionGroup')?->render();
			//
			
			$this('row')
				->id($LIST[$i]->rowId())
				->render();
			
			$this('row>checkbox')?->reset(true);
			$this('row>actionGroup')?->reset(true);
			$this('row>cell')?->reset(true);
		}
	}
};
?>
<cvp render="renderListBody">
    <tbody>
        <cvp:row widget />
    </tbody>
</cvp>
