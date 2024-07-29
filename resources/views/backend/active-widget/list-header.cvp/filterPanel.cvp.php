<?php
$renderListFilter = function() {
	$LIST = $this->widgetOwner;
	$form = $LIST->form();
	
	if ($form->filter instanceof \Kcms\Active\FormBody && count($form->filter))
	{
		/*if ($this->isTpl('search'))
		{
			$this('search')
				->searchValue((string)$form->search?->value())
				->searchActive($form->search?->value() != '' ? 'active' : '')
				// ->filterActive(count($LIST->filteredBy()) && $LIST->form()->search->value() == '' ? 'active' : '')
				->render();
		}*/
		
		if ($this->isTpl('filter'))
		{
            $form->filter->isReadonly($form->search?->value() != '');
			$this('filter')
				->displayFilter($form->search?->value() == '' && (count($LIST->filteredBy()) || ($this->openFilter??false)) ? '':'display: none;')
				->filterForm($form->filter->render())
				->render();
		}
	}
};
?>
<cvp render="renderListFilter">
    <cvp:filter>
        <div class="list-filter-panel js-filter-block" style="$displayFilter">
            <div class="list-filter-form js-active-list-form-filter">
                $filterForm
            </div>
            <div class="list-filter-actions">
                <button class="b-btn -small -radius bg-secondary-1 js-active-list-form-filter-button" title="{'Apply'}"><span class="b-btn__text">{'Apply'}</span></button>
                <button class="b-btn -small -radius bg-secondary-2 js-active-list-form-search-reset" title="{'Reset'}"><span class="b-btn__text">{'Reset'}</span></button>
            </div>
        </div>
    </cvp:filter>
</cvp>