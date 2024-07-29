<?
/**
 * @version 3.2.2016.1213
 * @version 3.2.2017.0208 - new UI
 * @version 3.2.2018.0531 - update
 * @version 3.6.2021.1124
 * @version 5.3.2023.0412 - page rendering moved from list-footer into own widget
 * @version 5.5.2023.1101
 */

$renderListFooter = function(){
	$LIST = $this->widgetOwner;
	$pager = $LIST->pager();
    
    //if (count($LIST)) $this('pager')->summary = printf($this->totalSummary, $LIST[0]->rowNumber(), $LIST[count($LIST)-1]->rowNumber(), $LIST->fetchCount());
    
    if ($pager)
	{
		$this('pager')
			->pager($pager->render())
			->render();
	}
};
?>
<cvp render="renderListFooter">
    </table>
    </div>
    <cvp:pager>$pager</cvp:pager>
</cvp>
