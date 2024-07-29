<?php View::Begin()?>
    <div class="b-formGrid__row -triple">
        <div class="b-formGrid__row">
			<?=$formAuthReset->password->render(fn($widget)=>$widget->data->icon('pass'))?>
			<?=$formAuthReset->passwordConfirm->render(fn($widget)=>$widget->data->icon('pass'))?>
			<?=$formAuthReset->identity->render()?>
        </div>
    </div>
<?php $html = View::End()?>
<?if (\Kcms\Active\UI_Form::IsContentRequested()):?>
	<?=$html?>
<?else:
	kApp()->layout()->title = x_lhtml('Change password');
	View::sectionTitle(kApp()->layout()->title);
	?>
    <div class="l-mainContent">
        <div class="b-mainContent">
            <form class="b-formGrid" kcms-role="active-form" action="<?=kAuth()->actionUrl('reset', 'url')?>" kcms-target-lazy-load="true">
                <div class="js-active-form-result">Password has changed. Please log in.</div>
                <div class="js-active-form-errors"></div>
                <div class="js-active-form-body">
					<?=$html?>
                </div>
                <div class="b-styleGuide__btnList">
                    <button type="submit" name="save" class="b-btn -outline bg-secondary-4"><span class="b-btn__text"><?=x_lhtml('Change')?></span></button>
                </div>
            </form>
        </div>
    </div>
<?endif;
