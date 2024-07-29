<?View::Begin()?>
    <div class="b-formGrid__row -triple">
        <div class="b-formGrid__row">
			<?=$formAuthLogin->login->render(fn($widget)=>$widget->data->icon('email'))?>
			<?=$formAuthLogin->password->render(fn($widget)=>$widget->data->icon('pass'))?>
			<?=$formAuthLogin->remember->render()?>
        </div>
    </div>
<?php $html = View::End()?>
<?if (\Kcms\Active\UI_Form::IsContentRequested()):?>
	<?=$html?>
<?else:
	kApp()->layout()->title = x_lhtml('Login');
	View::sectionTitle(kApp()->layout()->title);
	?>
    <div class="l-mainContent">
        <div class="b-mainContent">
            <form class="b-formGrid" kcms-role="active-form" action="<?=kAuth()->actionUrl('login', 'url')?>" kcms-target-lazy-load="true">
                <div class="js-active-form-result"></div>
                <div class="js-active-form-errors"></div>
                <div class="js-active-form-body">
					<?=$html?>
                </div>
                <div class="b-styleGuide__btnList">
                    <button type="submit" name="submit" class="b-btn -outline bg-secondary-4"><span class="b-btn__text"><?=x_lhtml('Sign In')?></span></button>
                    <p><a href="<?=kAuth()->actionUrl('forgotten', 'url')?>">Forgot password?</a></p>
                </div>
            </form>
        </div>
    </div>
<?endif;
