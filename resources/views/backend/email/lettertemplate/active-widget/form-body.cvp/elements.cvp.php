<div class="l-tableWrapper">
	<div class="b-tableWrapper">
		<ul class="b-tableWrapper__tabControl">
			<li class="b-tableWrapper__tabControlItem -state_active">
				<a class="b-tableWrapper__tabControlLink js-tabLink" href="#"><?=x_lhtml('Email Content')?></a>
			</li>
			<li class="b-tableWrapper__tabControlItem">
				<a class="b-tableWrapper__tabControlLink js-tabLink" href="#"><?=x_lhtml('Addresses')?></a>
			</li>
			<li class="b-tableWrapper__tabControlItem">
				<a class="b-tableWrapper__tabControlLink js-tabLink" href="#"><?=x_lhtml('Settings')?></a>
			</li>
		</ul>
		<div class="b-tableWrapper__tabContentWrapper">
			<div class="b-tableWrapper__tabContentItem js-tabContent" style="display: block">
				<div>
					<div class="b-formGrid__row">
						<div class="b-formGrid__row -double">
<!--                            <p>Note: Letter for <strong>--><?//=x_html($form->item->model()->application)?><!--</strong> application and <strong>--><?//=x_html($form->item->model()->lang)?><!--</strong> language</p>-->
							<?=$form->item->alias->render()?>
						    <div class="b-formGrid__row -double">
							    <?=$form->item->application->render()?>
							    <?=$form->item->lang->render()?>
                            </div>
						</div>
                        <?=$form->item->subject->render()?>
                        <?=$form->item->text->render()?>
                        <?=$form->item->plainText?->render()?>
                        <?=$form->item->isHTML?->render()?>
					</div>
				</div>
			</div>
			<div class="b-tableWrapper__tabContentItem js-tabContent">
				<div>
					<div class="b-formGrid__row">
						<?=$form->item->from?->render()?>
						<?=$form->item->to?->render()?>
						<?=$form->item->replyTo?->render()?>
						<?=$form->item->cc?->render()?>
						<?=$form->item->bcc?->render()?>
					</div>
				</div>
			</div>
			<div class="b-tableWrapper__tabContentItem js-tabContent">
				<div>
					<div class="b-formGrid__row">
						<?=$form->item->charset->render()?>
						<?=$form->item->headers->render()?>
						<?=$form->item->configProfile->render()?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
