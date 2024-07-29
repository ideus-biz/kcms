<?php

use Kcms\Core\Session_Layer;


$renderListColumns = function()
{
	$LIST = $this->widgetOwner;
    
    if ($this->isTpl('row>checkbox'))
	{
        $arr = \Kcms\Core\Arr::Cleanup($LIST->groupActions(), fn($v) => ($v->type() != \Kcms\Active\List_ActionType::GLOBAL));
        if (count($arr) && (!isset(Session_Layer::App()->editMode) || Session_Layer::App()->editMode)) $this('row>checkbox')->render();
    }
    
    //
	$cols = $LIST->columns();
	foreach ($cols as $name)
	{
		$el = $LIST->$name;
		
		$sort = $el->sortable();
		if ($sort)
		{
			$this('row>item>sortable')
				->label(x_lhtml($el->label()))
				->value('') // must be '' to enable sort request (or when $sort === true) or $sort number
				->dir(($sort === true || $sort == 0 ? 1 : -1 ) * (int)$sort/abs($sort)) // must be direction (-1 or 1) for the next sorting
				->status($sort !== true ? $sort < 0 ? 'upSort' : 'downSort' : 'none')
				/*->asc($sort !== true && $sort > 0 ? $sort : '')
				->desc($sort !== true && $sort < 0 ? $sort : '')
				->activeAsc($sort !== true && $sort > 0 ? 'abc' : '')
				->activeDesc($sort !== true && $sort < 0 ? 'cba' : '')*/
				->render();
		}
		else
		{
			$this('row>item>nonSortable')
				->label(x_lhtml($el->label()))
				->render();
		}
		
		$this('row>item')
			->name($name)
			->label(x_lhtml($el->label()))
			->render();
        
		
		$this('row>item>sortable')->reset();
		$this('row>item>nonSortable')->reset();
	}
    
    $this('row')->render();
}
?>
<cvp render="renderListColumns">
    <cvp:row>
        <tr>
            <cvp:checkbox widget />
            <cvp:item>
                <th class="js-active-list-cell" kcms-name="$name">
                    <cvp:sortable>
                    <button class="b-tableSort state_$status js-active-list-cell-sortable" type="button" kcms-value="$value" rel="$dir">
                        <span class="b-tableSort__text">$label</span>
                        <span class="b-tableSort__iconWrapper">
                            <span class="b-tableSort__leftArrow">
                              <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.66501 8L1.66502 2L2.66502 2L2.66501 8L1.66501 8Z" fill="#091B39"/>
                                <path d="M2.16502 -1.89276e-07L4.33008 2.25L-4.86115e-05 2.25L2.16502 -1.89276e-07Z" fill="#091B39"/>
                              </svg>
                            </span>
                            <span class="b-tableSort__rightArrow">
                              <svg width="5" height="8" viewBox="0 0 5 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.00002 4.37114e-08L3.00002 6H2.00002L2.00002 0L3.00002 4.37114e-08Z" fill="#B6B3B3"/>
                                <path d="M2.50002 8L0.334961 5.75L4.66509 5.75L2.50002 8Z" fill="#B6B3B3"/>
                              </svg>
                            </span>
                          </span>
                    </button>
                    </cvp:sortable>
                    <cvp:nonSortable>
                        <button class="b-tableSort" type="button">
                            <span class="b-tableSort__text">$label</span>
                            <span class="b-tableSort__iconWrapper">
                          </span>
                        </button>
                    </cvp:nonSortable>
                </th>
            </cvp:item>
            <td>&nbsp;<!--for row actions--></td>
        </tr>
    </cvp:row>
</cvp>