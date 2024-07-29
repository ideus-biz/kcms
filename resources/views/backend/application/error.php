<div class="l-simpleContent">
    <div class="b-simpleContent">
        <h2 class="b-simpleContent__title">Error</h2>

        <div class="b-simpleContent__text b-text">
            <p>
                HTTP ERROR <?=\Kcms\Core\Request::Current()->response()->getStatusCode()?>
            </p>
        </div>
    </div>
</div>
