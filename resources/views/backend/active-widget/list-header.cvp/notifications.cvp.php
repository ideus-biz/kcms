<?php
$render = function()
{
	$LIST = $this->widgetOwner;
    
    // Col cells + cell for row actions
    $elCols = count($LIST->columns()) + 1;
    // Plus 1 if header has checkbox
	$arr = $LIST->groupActions();
	unset($arr['add']);
    $elCols += count($arr) > 0;
    
	if ($LIST->isUserAllowedTo(\Auth::PRIV_READ))
	{
		if (!count($LIST))
		{
            $filtered = count($LIST->filteredBy());
			if (!empty($filtered))
			{
                $this->isTpl('notFound') && $this('notFound')->msg(isset($this->nothingFoundMessage)? x_html($this->nothingFoundMessage) :x_lhtml('Nothing is found'))->colspan($elCols)->render();
			}
			elseif ($this->isTpl('empty'))
			{
                $this('empty')->colspan($elCols)
                    ->msg(isset($this->emptyListMessage)? x_html($this->emptyListMessage) :x_lhtml('The list is empty'))
                    ->render();
			}
		}
	}
	else
	{
		$this->isTpl('denied') && $this('denied')->colspan($elCols)->render();
	}
};
?>
<cvp render="render">
    <tr>
        <cvp:denied>
        <td class="table-error" colspan="$colspan">{'You are forbidden to view this list'}</td>
        </cvp:denied>
        <cvp:empty>
        <td class="table-error" colspan="$colspan">$msg</td>
        </cvp:empty>
        <cvp:notFound>
        <td class="table-error" colspan="$colspan">$msg</td>
        </cvp:notFound>
    </tr>
</cvp>