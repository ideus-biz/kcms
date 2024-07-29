<?php
$render = function()
{
	if (!\Kcms\Active\UI_List::IsContentRequested())
	{
		$path = [];
		if (Menu::HasMenu('breadcrumbs'))
		{
			foreach (Menu::Instance('breadcrumbs') as $v)
			{
				if ($v->target()) $s = DOM::A($v->title())->href($v->target());
				else $s = $v->title();
				$path[] = $v->dom(DOM::Span())->html($s);
			}
		}
		
		$this('list')
			// ->sectionTitle(DOM::H1(x_html($this->sectionTitle)))
			->breadcrumbs(DOM::span(Arr::Implode($path, ' / '))->addClass('b-breadcrumbs'))
			->list($this->list->widget()->wrapper->render())
			->render();
	}
	else
	{
		$this('body')
			->list($this->list->widget()->wrapper->render())
			->render();
	}
};
?>
<cvp render="render">
    <cvp:body>
        $list
    </cvp:body>
    <cvp:list>
        <div class="l-mainContent">
            <div class="b-mainContent">
                $breadcrumbs
                <div class="js-context-list">
                    $list
                </div>
            </div>
        </div>
    </cvp:list>
</cvp>
