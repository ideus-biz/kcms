<?php

/**
 * 
 * Available template variables:
 * $ATTRS - Kcms_Container with predefined HTML attributes:
 *  - string `id` - based on the normalized element name and sequential list index;
 *  - string `style` - optional, ready-to-use string of CSS styles based on the element's widget style property;
 * $DATA - Kcms_Container with predefined properties:
 * 	- string`name` - name of a element that is being rendered;
 * 	- string`value` - value of a element for the current list's row index
 * $DATA may also contain any custom data.
 * 
 * @category	KCMS Active Form Widget
 * @package		KCMS v3.3 Active plugin
 * @author		Andrey Potapov
 * @copyright     2010-2023    Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license		LGPL
 * @since		X.2011
 * @version 	3.2.2013.0808
 */

?>
<?if (!empty($value)):?><img src="<?=Resource_Image::Url($value, 'img_96')?>" /><?endif;?>
