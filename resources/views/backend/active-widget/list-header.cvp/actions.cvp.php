<?php
/**
 * Overwrite this microtemplate if you need to reposition its templates or customize the view.
 * Included microtemplates must be located in ./actions.cvp/ subfolder or defined right here.
 * 
 * If you need CVP renderer for included microtemplates then all of them must be located in list-header.cvp/ folder
 */
?>
<?x_cvp_widget('filter')?>
<cvp:add>$html</cvp:add>
<cvp:status>$html</cvp:status>
<cvp:moveup>$html</cvp:moveup>
<cvp:movedn>$html</cvp:movedn>
<cvp:restore>$html</cvp:restore>
<cvp:archive>$html</cvp:archive>
<cvp:delete>$html</cvp:delete>
<?x_cvp_widget('custom')?>
<?/*x_cvp_widget('reset')*/?>
<cvp:export>$html</cvp:export>
<cvp:reload>$html</cvp:reload>
