<div id="tabs">
    <ul>
        <li><a href="#tabs-account">User Account</a></li>
        <li><a href="#tabs-profile">User Profile</a></li>
    </ul>
    <div id="tabs-account">
        <div class="column">
            <div class="form-control">
				<?=$form->user->email->render()?>
            </div>
			<?if (isset($form->user->username)):?>
                <div class="form-control">
					<?=$form->user->username->render()?>
                </div>
			<?endif;?>
			<?if (isset($form->user->password)):?>
                <div class="form-control">
					<?=$form->user->password->render()?>
                </div>
			<?endif;?>
			<?if (isset($form->user->newPassword)):?>
                <div class="form-control">
					<?=$form->user->newPassword->render()?>
                </div>
			<?endif;?>
			<?if (isset($form->user->confirmPassword)):?>
                <div class="form-control">
					<?=$form->user->confirmPassword->render()?>
                </div>
			<?endif;?>
            <div class="form-control">
                <?=$form->user->isConfirmed->render()?>
            </div>
            <div class="form-control">
				<?=$form->user->isActive->render()?>
            </div>
			<?if (isset($form->loginas)):?>
                <div class="form-control">
					<?=$form->loginas->render()?>
                </div>
			<?endif;?>
        </div>
    </div>
    <div id="tabs-profile">
        <div class="column">
            <div class="form-control">
				<?=$form->account?->photo?->widget()->body->render()?>
            </div>
			<?if (isset($form->account->title)):?>
                <div class="form-control">
					<?=$form->account->title->render()?>
                </div>
			<?endif;?>
			<?if (isset($form->address->website)):?>
                <div class="form-control">
					<?=$form->address->website->render()?>
                </div>
			<?endif;?>
            <div class="form-control">
				<?=$form->account->firstName?->render()?>
            </div>
            <div class="form-control">
				<?=$form->account->lastName?->render()?>
            </div>
            <!--<div class="form-control">
				<?/*=$form->address->phone1->render()*/?>
            </div>-->
        </div>
    </div>
</div>
