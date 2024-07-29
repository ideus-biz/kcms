<?php View::Begin()?>
    <div class="b-formGrid__row -triple">
		<?=$formAuthForgotten->email->render()?>
    </div>
<?php $html = View::End()?>
<?if (\Kcms\Active\UI_Form::IsContentRequested()):?>
	<?=$html?>
<?else:
	kApp()->layout()->title = x_lhtml('Forgotten password');
	View::sectionTitle(kApp()->layout()->title);
	?>
    <div class="l-mainContent">
        <div class="b-mainContent">
            <form class="b-formGrid" kcms-role="active-form" action="<?=kAuth()->actionUrl('forgotten', 'url')?>" kcms-target-lazy-load="true">
                <div class="js-active-form-result"><?=x_lhtml('Letter with instructions has sent to your email. Please check it out.')?></div>
                <div class="js-active-form-errors"></div>
                <div class="js-active-form-body">
					<?=$html?>
                </div>
                <div class="b-styleGuide__btnList">
                    <button type="submit" name="save" class="b-btn -outline bg-secondary-4"><span class="b-btn__text"><?=x_lhtml('Send')?></span></button>
                </div>
            </form>
        </div>
    </div>
<?endif;
