<?php View::Begin()?>
    <div class="b-formGrid__row">
		<?=$formAuthProfile->user->photo->widget()->body->render()?>
    </div>
    <div class="b-formGrid__row -double">
		<?=$formAuthProfile->user->firstName->render()?>
		<?=$formAuthProfile->user->lastName->render()?>
		<?=$formAuthProfile->user->email->render(fn($widget)=>$widget->data->icon('email'))?>
		<?=$formAuthProfile->account->orderNotification->render()?>
		<?=$formAuthProfile->address->phone1->render()?>
		<?=$formAuthProfile->account->phones->render(fn($w)=>$w->data->hint('One phone per line'))?>
		<?=$formAuthProfile->account->lang->render()?>
        <span></span>
		<?=$formAuthProfile->user->newPassword->render(fn($widget)=>$widget->data->icon('pass')->hint('Change your password'))?>
		<?=$formAuthProfile->user->confirmPassword->render(fn($widget)=>$widget->data->icon('pass'))?>
    </div>
<?php $html = View::End()?>
<?if (\Kcms\Active\UI_Form::IsContentRequested()):?>
	<?=$html?>
<?else:
    kApp()->layout()->title = x_lhtml('Profile');
	View::sectionTitle(kApp()->layout()->title);
    ?>
    <div class="l-tableWrapper">
        <div class="b-tableWrapper">
            <div class="b-tableWrapper__tabContentWrapper">
                <div class="b-tableWrapper__tabContentItem js-tabContent" id="tab-info" style="display: block">
                    <div>
                        <form class="b-formGrid" kcms-role="active-form" action="<?=kAuth()->actionUrl('profile', 'url')?>" kcms-target-lazy-load="true" kcms-option-steady-layer="false">
                            <div class="js-active-form-result"><?=x_lhtml('Profile updated')?></div>
                            <div class="js-active-form-errors"></div>
                            <div class="js-active-form-body">
								<?=$html?>
                            </div>
                            <div class="b-styleGuide__btnList">
                                <button type="submit" name="save" class="b-btn -outline bg-secondary-4" name="save"><span class="b-btn__text"><?=x_lhtml('Save')?></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?endif;