<?php
/**
 * Шаблон виджета KCMS Active Uploader XHR, используемый формой \Kcms\Active\Form_Upload
 *
 * JS код загрузчика расположен в ресурсе uploader-xhr.js модуля KCMS Active
 *
 * @category   KCMS Active Form Widget
 * @package    KCMS Active
 * @author     Andrey Potapov
 * @copyright     2010-2023 Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      VII.2011
 * @version    3.2.2013.0712 - deprecated using Valums JS uploader
 * @since      V.2016
 * @version    3.2.2016.0523
 * @version    3.2.2016.0824 - use Active XHR uploader
 * @version    3.2.2017.0215 - review
 * @version    3.2.2020.0306 - js-* classes change to js-auxhr-
 * @version    5.0.2021.0518 - Add max file size control. Goodbye DA forever ;(
 * @version    5.1.2021.1125 - drop zone label can be changed
 * @version    5.3.2022.1215 - DOM is used
 * @version    5.3.2023.0405 - fix file input disabling
 * @version    5.3.2023.0411 - list of saved files moved from form-body/active_form_upload.php into here
 * @version    5.3.2023.1020
 *
 * @var \Kcms\Active\Form_Element $widgetOwner Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var \Kcms\Active\Uploader_XHR $uploader
 * @var int $optionConnections
 * @var string $url
 * @var mixed $any  Any variable from widget's data container
 */

$optionConnections = intval($optionConnections ?? 1);
$form = $widgetOwner->owner();
$sourceFiles = $form->files();
if (count($sourceFiles))
{
	$DOMLabel->html(__('Upload new '.$widgetOwner->label()));
	$domSavedFiles = DOM::div()->addClass('js-list-saved');
	
	foreach ($sourceFiles as $k => $v)
	{
		$actions = $form->fileActionElement($k);
		if ($v instanceof \Kcms\Core\FS_File && $actions)
		{
            if ($v->contextPath() == PROTECTEDROOT || !str_starts_with($v->mime(), 'image/'))
			{
				$domFile = DOM::img(Resource_Image::Url(x_uri_res('assets/img/icons/view-doc.png', 'base'), RES_IMG_48))->title('View document: '.$v->basename())->alt($v->basename());
            }
            else
            {
                $domFile = DOM::img(Resource_Image::Url($v->relativePath(), RES_IMG_96).'?_='.$v->timeModified())->title($v->basename())->alt($v->basename());
            }
            
			$action = $actions['delete']??null;
			if (isset($action) && $action->isModifier())
			{
				$action->widget()->dom()->kcms('role2', 'active-link')->kcms('target', '')->kcms('target-method', 'post')
					->kcms('target-data', $action->htmlName().'=1')->kcms('assoc-context', 'ActiveForm')
					->kcms('option-confirm', __('Delete this file?'));
			}
			$domSavedFiles->append(
				DOM::div()->html(
					DOM::a($domFile)->href($form->fileUrl($k).'?_='.$v->timeModified())->target('_blank'),
					...array_values($actions)
				)
			);
		}
	}
}
?>
<div class="js-auxhr-context">
	<?=$domSavedFiles??''?>
    <div kcms-role="active-form-uploader-xhr"
         kcms-target="<?=(!empty($url) ? x_uri($url) : '')?>"
         kcms-name="<?=x_spc($uploader->collectionName())?>"
         kcms-option-connections="<?=$optionConnections?>"
         id="<?=x_spc($DOM->id)?>"
         class="b-uploader-xhr"
    >
		<?=$DOMLabel->addClass('js-auxhr-label')?>
        <label class="b-uploader js-auxhr-dropZone">
            <input class="js-auxhr-input" type="file"
                   <?=$DOM->disabled ? 'disabled':''?>
                    <?=($uploader->config->isMultiple() ? 'multiple':'')?>
                   accept="<?=$DOM->accept??'*'?>"
                    <?=!empty($DOM->capture) ? 'capture="'.x_spc($DOM->capture).'"' : ''?>
            />
            <div class="b-uploader__container">
                <?if (isset($dropZoneLabel)):?>
                    <?=x_lhtml($dropZoneLabel)?>
                <?else:?>
                    <span class="b-uploader__btn">+</span>
                    <span class="b-uploader__area"><?=x_lhtml('Drop Area')?></span>
                <?endif;?>
            </div>
        </label>

    <!--ul class="js-auxhr-list-uploading"></ul-->

    <ul class="js-auxhr-list-uploaded">
		<?
		$list = $uploader->listUploadedFiles();
		if (!empty($list)):?>
			<?foreach ($list as $k => $v):?>
                <li class="js-auxhr-file js-auxhr-file-status-uploaded" data-file-id="<?=x_spc($k)?>">
                    <span class="js-auxhr-file-preview" data-url="<?=x_uri($v->url())?>" data-mime="<?=x_spc($v->mime())?>"><img width="96"/></span>
                    <a class="js-auxhr-file-label" href="<?=x_uri($v->url())?>"><?=x_html($v->basename)?></a>
                    <span class="js-auxhr-file-action-cancel"><?=x_lhtml('cancel')?></span>
                </li>
			<?endforeach;?>
		<?endif;?>
    </ul>

    <ul class="js-auxhr-list"></ul>

    <template class="file-uploading" data-insert="prepend">
        <li class="js-auxhr-file">
            <span class="js-auxhr-file-preview"><img width="96"/></span>
            <span class="js-auxhr-file-label"><a href=""></a></span>
            <!--span class="js-auxhr-file-progress">0%</span-->
            <progress class="js-auxhr-file-progress" value="0" max="100"></progress>
            <span class="js-auxhr-file-message">
				<label class="js-auxhr-file-message-aborted" style="display: none;"><?=x_lhtml('Transmission aborted')?></label>
				<label class="js-auxhr-file-message-done" style="display: none;"><?=x_lhtml('Completed')?></label>
				<label class="js-auxhr-file-message-error" style="display: none;"><?=x_lhtml('Unknown error')?></label>
				<label class="js-file-message-error-http" style="display: none;"></label>
				<label class="js-file-message-error-timeout" style="display: none;"></label>
				<label class="js-file-message-error-max-size" style="display: none; color:red;">File exceeded max allowed size.</label>
			</span>
            <a href="" class="js-auxhr-file-action-cancel"><?=x_lhtml('cancel')?></a>
        </li>
    </template>
</div>
</div>
