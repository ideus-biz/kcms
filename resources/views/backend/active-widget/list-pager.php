<?
/**
 * @version 5.3.2023.0412 - page rendering moved from list-footer into own widget
 * @version 5.3.2023.0711 - auto hiding logic moved here from pager class
 * @version 5.5.2023.1101
 */

$renderPager = function(){
	/*@var Pager $pager */
	$pager = $this->widgetOwner;
	
	$totalItems = $pager->totalItems();
	$totalPages = $pager->totalPages();
	$currentPage = $pager->currentPage();
    $pageSizes = $pager->itemsPerPageChoice();
    
    if ($pager->isAutoHide() && $totalPages <= 1 && empty($pageSizes)) return;
    
	if (is_object($pager) && $totalPages > 0)
	{
		if ($this->isTpl('size>item') && count($pageSizes) && $totalItems > $pageSizes[0])
		{
			for ($i = 0; $i < count($pageSizes); $i++)
			{
                $res = $totalItems < $pageSizes[$i];
                $this('size>item')
                    ->size($pageSizes[$i])
                    ->active($pager->itemsPerPage() == $pageSizes[$i] ? 'selected' : '')
                    // ->hint(__('Show %ipp% rows per page', ['%ipp%' => $pageSizes[$i]]), true)
                    ->hint('')
                    ->render();
                if ($res) break;
			}
			if ($this('size>item')->hasRendered()) $this('size')->render();
		}
		
		$tpl = $this('page');
		$pagesPerInterval = 4;
		$pagesPerInterval1 = $pagesPerInterval+1;
		
		$this('prev')
			->label('Prev', true, true)
			->number($currentPage > 1 ? $currentPage-1:1)->disabled($currentPage == 1 ? 'disabled':'')
			->render();
		for ($i = 1; $i <= $totalPages; $i++)
		{
			$d2 = $currentPage-$pagesPerInterval1 <= 0 ? abs($currentPage-$pagesPerInterval1)+2 : intval($currentPage-$pagesPerInterval1 == 1);
			$d1 = $currentPage+$pagesPerInterval1 > $totalPages ? ($currentPage+$pagesPerInterval1)-$totalPages+1 : intval($totalPages-$currentPage == $pagesPerInterval1);
			
			if ($i == 1 || $i == $totalPages || $totalPages <= $pagesPerInterval*2+2+2+1)
			{
				$tpl->number($i)->label($i)
					->disabled($currentPage == $i ? 'disabled' : '')
					->active($currentPage == $i ? 'active' : '')
					->render();
			}
            elseif ($i > $currentPage-$pagesPerInterval1-$d1 && $i < $currentPage+$pagesPerInterval1+$d2)
			{
				$tpl->number($i)->label($i)
					->disabled($currentPage == $i ? 'disabled' : '')
					->active($currentPage == $i ? 'active' : '')
					->render();
			}
            elseif ($i == $currentPage-$pagesPerInterval1-$d1)
			{
				$tpl->number($i-$pagesPerInterval > 0 ? $i-$pagesPerInterval : 1)->label('...')
					->disabled($currentPage == $i ? 'disabled' : '')
					->active($currentPage == $i ? 'active' : '')
					->render();
			}
            elseif ($i == $currentPage+$pagesPerInterval1+$d2)
			{
				$tpl->number($i+$pagesPerInterval < $totalPages ? $i+$pagesPerInterval : $totalPages)->label('...')
					->disabled($currentPage == $i ? 'disabled' : '')
					->active($currentPage == $i ? 'active' : '')
					->render();
			}
		}
		$this('next')
			->label('Next', true, true)
			->number($currentPage < $totalPages?$currentPage+1:$totalPages)->disabled($currentPage == $totalPages ? 'disabled':'')
			->render();
	}
};
?>
<cvp render="renderPager">
    <div class="b-pagination">
        <ul class="b-pagination__list">
            <cvp:prev>
                <li class="b-pagination__item $disabled">
                    <a class="b-pagination__link -type_prev js-active-list-pager-page-number" href="#$number" kcms-value="$number">
                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.53326 3.92213L8.73326 3.99991" stroke="#34435E" stroke-width="0.818183" stroke-linecap="round"/>
                            <path d="M3.96812 1L1 4L3.96812 7" stroke="#34435E" stroke-width="0.818183" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        $label
                    </a>
                </li>
            </cvp:prev>
            <cvp:page>
                <li class="b-pagination__item $active $disabled">
                    <a href="#$number" kcms-value="$number" class="b-pagination__link js-active-list-pager-page-number">$label</a>
                </li>
            </cvp:page>
            <cvp:next>
                <li class="b-pagination__item $disabled">
                    <a class="b-pagination__link -type_next js-active-list-pager-page-number" href="#$number" kcms-value="$number">
                        $label
                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.46671 3.92213L1.26671 3.99991" stroke="#34435E" stroke-width="0.818183" stroke-linecap="round"/>
                            <path d="M6.03188 1L9 4L6.03188 7" stroke="#34435E" stroke-width="0.818183" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
            </cvp:next>
        </ul>
        <cvp:size widget />
    </div>
</cvp>
