<?php
    $render = function(){
		if (\Kcms\App\Menu::HasMenu('main'))
		{
            foreach (\Kcms\App\Menu::Instance('main') as $v)
			{
				$this->tpl('menu>item')
                    ->id($v->id())
                    ->title(x__($v->title()))
                    ->target($v->target())
                    ->activeClass($v->isSelected()?'-state_active':'')
                    ->render();
            }
            
            $this->tpl('menu')->render();
        }
    };
?>
<cvp render="render">
    <cvp:menu>
        <nav class="l-mainNavigation">
            <ul class="b-mainNavigation">
            <cvp:item>
                <li class="b-mainNavigation__item $activeClass">
                    <a class="b-mainNavigation__link" href="$target">
                        <span class="b-mainNavigation__icon -$id"></span>
                        $title
                    </a>
                </li>
            </cvp:item>
            </ul>
        </nav>
    </cvp:menu>
</cvp>