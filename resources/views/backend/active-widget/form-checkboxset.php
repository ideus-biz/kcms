<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<?if($DOMLabel->get(0)):?>
    <div class="b-formGroup__labelWrapper">
		<?=$DOMLabel->addClass('b-formGroup__label', ($DOM->required?'-required':''))->append(($DOM->required?DOM::Span('*'):''))?>
		<?if(!empty($tooltip)):?>
            <div class="b-tooltip js-tooltip t-right-top" title="<?=nl2br(htmlspecialchars($tooltip, ENT_COMPAT, \Kcms\Core\UTF8::CHARSET))?>"></div>
		<?endif;?>
    </div>
	<?endif;?>
    <div class="b-formGroup__smallRow">
		<?foreach($choice as $k => $v):
			$newDOM = $domCheckbox($k, $v);
			$newDOM->addClass('b-formGroup__checkbox js-checkbox');
			$newDOM->autocomplete('off');
			?>
            <div class="b-formGroup__fieldWrapper -checkbox">
				<?=$newDOM?>
				<?=($v != '' ? \Kcms\Active\DOM::Label(x_lhtml($v))->for($newDOM->id)->addClass('b-formGroup__checkboxText') : '')?>
            </div>
			<?endforeach;?>
    </div>
	<?if (isset($hint)):?>
        <div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
