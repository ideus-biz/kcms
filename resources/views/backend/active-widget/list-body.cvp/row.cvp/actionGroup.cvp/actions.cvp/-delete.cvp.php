<cvp:active>
    <a href="#delete" class="b-table__deleteLink btn-danger js-active-list-action"
       kcms-name="delete" kcms-type="row-action" kcms-option-resetSelection="true"
       kcms-option-confirm="{'Warning! Are you really sure you need to delete this record permanently?'}"
       title="$hint"
    >
        $title
    </a>
</cvp:active>
<cvp:inactive>
    <a href="#" disabled class="b-table__deleteLink btn-danger" title="$hint" style="color: darkgray;">$title</a>
</cvp:inactive>
