<?php
$render = function(){
	
	$render = function($element, $render)
	{
		foreach ($element as $v)
		{
			if ($v instanceof \Kcms\App\Form_Upload)
			{
				$this('element')->input($v->widget()->body->render())->render();
			}
			elseif ($v instanceof \Kcms\Active\FormBody)
			{
				$render($v, $render);
			}
			else
			{
				$this('element')->input($v->render())->render();
			}
		}
	};
	
	$render($this->widgetOwner, $render);
}
?>

<cvp render="render">
    <div class="b-formGrid__row">
		<cvp:element>
			$input
        </cvp:element>
	</div>
</cvp>