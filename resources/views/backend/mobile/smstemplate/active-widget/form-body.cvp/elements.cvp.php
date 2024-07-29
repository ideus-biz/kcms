<div class="b-formGrid__row">
    <div class="b-formGrid__row -double">
		<?=$form->item->alias->render()?>
        <div class="b-formGrid__row -double">
			<?=$form->item->application->render()?>
			<?=$form->item->lang->render()?>
        </div>
    </div>
    <div class="b-formGrid__row -triple">
	<?=$form->item->from?->render()?>
	<?=$form->item->phones?->render()?>
	<?=$form->item->configProfile?->render()?>
    </div>
	<?=$form->item->text->render()?>
</div>
