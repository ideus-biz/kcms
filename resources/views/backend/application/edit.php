<?php

use Kcms\Active\DOM;


$render = function(){
	if (!\Kcms\Active\UI_Form::IsContentRequested())
	{
		/*if (Application::Instance()->layout()->title == '')
		{
			Application::Instance()->layout()->title = ($this->sectionTitle ? $this->sectionTitle.' - ' : '').'Administration';
		}*/
		
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
		
		if (!$this->form->widget()->wrapper->dom()->layerResult()->html())
		{
			$this->form->widget()->wrapper->dom()->layerResult()->html(x_lhtml('Form data has been submitted.'));
		}
		
		$this('form')
			// ->sectionTitle(DOM::H1(x_html($this->sectionTitle)))
			->breadcrumbs(DOM::span(Arr::Implode($path, ' / '))->addClass('b-breadcrumbs'))
			->form($this->form->widget()->wrapper->render())
			->render();
	}
	else
	{
		$this('body')
			->form($this->form->widget()->wrapper->render())
			->render();
	}
}
?>

<cvp render="render">
    <cvp:body>
        $form
    </cvp:body>
    <cvp:form>
        <div class="l-mainContent">
            <div class="b-mainContent">
                $breadcrumbs
                <div class="js-context-form">
                    $form
                </div>
            </div>
        </div>
    </cvp:form>
</cvp>