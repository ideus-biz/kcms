<?php
$render = function(){
	$this('elements')->render();
	$this('actions')->render();
};
?>

<cvp render="render">
    <cvp:elements widget/>
    <cvp:actions widget/>
</cvp>
