<?php
/**
 * KCMS Active Form Widget Hidden template
 * 
 * Visualizes {@see \Kcms\Active\Form_Element} as form's HTML INPUT tag of type text with or w/o LABEL tag.
 * 
 * @category   KCMS Active Form Widget
 * @package    KCMS Active
 * @author     Andrey Potapov
 * @copyright     2010-2023 Andrey Potapov aka ultimus <andrew@ideus.biz>
 * @license    LGPL
 * @since      X.2011
 * @version    3.2.2013.0607
 * @version    5.3.2022.1215 - DOM is used
 *
 * @var \Kcms\Active\Form_Element $element Form's element object
 * @var \Kcms\Active\DOM_Tag $DOM  DOM of input element
 * @var \Kcms\Active\DOM_Tag $DOMLabel  Label DOM of input element
 * @var array $choice
 * @var mixed $any  Any variable from widget's data container
 */

$DOM->type = 'hidden';
echo $DOM;
