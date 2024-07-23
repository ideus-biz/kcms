<?php

use App\Backend\Controller_CompanyAdmin_Company_Document;


?>
<div class="l-tableWrapper">
    <div class="b-tableWrapper">
        <ul class="b-tableWrapper__tabControl">
            <li class="b-tableWrapper__tabControlItem -state_active">
                <a class="b-tableWrapper__tabControlLink js-tabLink" href="#"><?=x_lhtml('User Account')?></a>
            </li>
            <li class="b-tableWrapper__tabControlItem">
                <a class="b-tableWrapper__tabControlLink js-tabLink" href="#"><?=x_lhtml('User Profile')?></a>
            </li>
        </ul>
        <div class="b-tableWrapper__tabContentWrapper">
            <div class="b-tableWrapper__tabContentItem js-tabContent" style="display: block">
                <div>
                    <div class="b-formGrid__row -double">
						<?=$form->user->email?->render()?>
						<?=$form->user->username->render()?>
                    </div>
                    <div class="b-formGrid__row -double">
						<?=$form->user->password?->render()?>
						<?=$form->user->newPassword?->render()?>
						<?=$form->user->confirmPassword->render()?>
                    </div>
                    <div class="b-formGrid__row -double">
						<?=$form->user->isConfirmed?->render()?>
						<?=$form->user->isActive?->render()?>
                    </div>
                    <div class="b-formGrid__row">
						<?=$form->loginas?->render()?>
                    </div>
                </div>
            </div>
            <div class="b-tableWrapper__tabContentItem js-tabContent">
                <div>
                    <div class="b-formGrid__row">
						<?=$form->account?->photo?->widget()->body->render()?>
                    </div>
                    <div class="b-formGrid__row -double">
						<?=$form->user->firstName?->render()?>
						<?=$form->user->lastName?->render()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
