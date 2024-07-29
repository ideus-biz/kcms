<div class="b-formGroup <?=(isset($hint)?'-info':'')?>">
	<?if($DOMLabel->get(0)):?>
		<?=$DOMLabel->addClass('b-formGroup__label')?>
	<?endif;?>
    <div class="b-formGroup__smallColumn">
		<?foreach($choice as $k => $v):
			$newDOM = $domRadio($k, $v);
			$newDOM->addClass('b-formGroup__radio js-radio');
			$newDOM->autocomplete('off');
			?>
            <div class="b-formGroup__fieldWrapper -radio">
				<?=$newDOM?>
				<?=($v != '' ? \Kcms\Active\DOM::Label(x_lhtml($v))->for($newDOM->id)->addClass('b-formGroup__radioText') : '')?>
            </div>
		<?endforeach;?>
    </div>
	<?if (isset($hint)):?>
        <div class="b-formGroup__helpText"><?=x_lhtml($hint)?></div>
	<?endif;?>
</div>
