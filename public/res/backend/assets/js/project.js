$(document).ready(function () {
});

function generalInit(context)
{
	inputMasquerading(context);
	initUploaders(context);
	initDatepicker(context);
	initFieldAutocomplete(context);
	initTab(context);
}


$(window).on('load', function () {
});


$(window).on('kcmsReady', function() {
	generalInit();
	initListFilter();
	
	ActiveWidget.EventOn('activated', function (widget) {
		generalInit(widget.context);
		
		initSelectPlugin(widget.context);
		initFormStyler(widget.context);
		initTab(widget.context);
	});
	
	ActiveForm.EventOn('activated', function (form) {
		const $el = $('.js-tabLink[href="'+location.hash+'"]', form.domElement);
		if (location.hash && $el.length) selectTab($el);
	});
});


// TABS
function selectTab($this){
	const $tab = $this.parents('.b-tableWrapper__tabControl').first().parent();
	let controlIndex = $this.parents('li').first().index();
	$('.b-tableWrapper__tabControlItem', $tab).removeClass('-state_active');
	$this.parents('.b-tableWrapper__tabControlItem').first().addClass('-state_active');
	$('.js-tabContent', $tab).hide().eq(controlIndex).show();
}

function initTab(context) {
	
	$('.js-tabLink', context).on('click', function (e) {
		e.preventDefault();
		
		const $this = $(this);
		selectTab($this);
		
		const tabHref = $this.attr('href');
		if (tabHref.startsWith('#') && tabHref.length > 1 && $(tabHref).length)
		{
			const url = new URL(location.href);
			url.hash = tabHref.trim('#');
			history.replaceState(null, '', url);
		}
	});
	
	if (!context)
	{
		if (location.hash && $('.js-tabContent'+location.hash).length)
		{
			const $el = $('.js-tabLink[href="'+location.hash+'"]');
			if ($el.length) selectTab($el);
		}
	}
}
//


function validatePhone($element)
{
	const $code = $('select', $element);
	const $phone = $('input', $element);
	if (!empty($code) && !empty($phone))
	{
		const code = $code.find('option:selected').data('code');
		let phone = $phone.val();
		if (phone)
		{
			if (code)
			{
				phone = formatInternational(code, phone);
				const validNumber = isValidNumber(phone, code);
				if (validNumber)
				{
					$element.parent().addClass('-correct').removeClass('-error');
					$phone.val(phone);
				}
				else $element.parent().addClass('-error').removeClass('-correct');
			}
			else $element.parent().addClass('-error').removeClass('-correct');
		}
		else $element.parent().removeClass('-error').removeClass('-correct');
	}
}


function initUploaders(context)
{
	ActiveFormUploaderXHR.Find('', context).each((widget)=>{
		widget.eventOn('post', (self, data)=>{
			if (data.reload)
			{
				self.parentWidget().load();
			}
		});
	});
}


function initListFilter(context)
{
	ActiveList.Find('', context).each(widget=>{
		//widget.selectElement('.js-open-filter').on('click', e=>{
		widget.contextEvent('.js-open-filter', 'click', e=>{
			const $filter = widget.selectElement('.js-filter-block');
			if (!empty($filter))
			{
				const display = $filter.css('display');
				if (display === 'block') $filter.hide();
				else if (display === 'none') $filter.show();
			}
		});
	});
}

function initDatepicker(context) {
	const region = $('html').attr('lang')??'en';
	$.datepicker.setDefaults($.datepicker.regional[region]??$.datepicker.regional['en']);
	
	$('.js-calendar', context).not('[readonly]').each(function (){
		$(this).datepicker({
			autoclose: true,
			dateFormat: $(this).attr('data-dateformat')??"mm/dd/yy",
			firstDay: 1,
			showOtherMonths: true,
			// dayNamesMin: [ "Sun", "Mon", "Tue", "Wen", "Thu", "Fri", "Sat" ],
			minDate: $(this).attr('data-min-date'),
			maxDate: $(this).attr('data-max-date'),
			onClose: function() {
				$(this).parent().removeClass('ui-active');
			},
			beforeShow: function() {
				$(this).parent().addClass('ui-active');
			}
		});
	});
}

async function initGMap(domMap, cfg) {
	// Request libraries when needed, not in the script tag.
	const { Map } = await google.maps.importLibrary('maps');
	// Short namespaces can be used.
	x_log('initGMap');
	return new Map(domMap, cfg);
}


function initFieldAutocomplete(context)
{
	$('.js-field-autocomplete', context).each((i, el)=>{
		const $el = $(el);
		
		const form = ActiveForm.FindParent($el);
		if (form instanceof ActiveForm)
		{
			form.eventOn('submit', (form)=>{
				if ($el.data('autocompleteIsOpened')) return false;
			});
		}
		
		if ($el.data('url'))
		{
			$el.data('prev-value', $el.val());
			
			let $elVal = null;
			if ($el.data('input'))
			{
				$elVal = $($el.data('input'), context);
			}
			
			const plugin = $el.autocomplete({
				minLength: $el.data('min-length')??0,
				delay: $el.data('delay')??300,
				source: $el.data('url'),
				focus: function(event, row) {
					empty($elVal) ? $el.val(row.item.value) : $el.val(row.item.label);
					return false;
				},
				select: function( event, row ) {
					if (!empty($elVal))
					{
						$el.val(row.item.label);
						$el.data('prev-value', $el.val());
						$elVal.val(row.item.value);
						$elVal.data('prev-value', $elVal.val());
					}
					else $el.val(row.item.value);
					
					return false;
				},
				open: function (event, ui){
					$el.data('autocompleteIsOpened', true);
				},
				close: function (event, ui){
					setTimeout(()=>$el.data('autocompleteIsOpened', false), 200);
				},
			});
			
			plugin.autocomplete('instance')._renderMenu = function (ul, items) {
				var that = this;
				$.each(items, function (index, item) {
					that._renderItemData(ul, item);
				});
				$(ul).css('z-index', 11000);
			}
			
			if (!empty($elVal)) {
				$el.on('keyup', (e) => {
					if ($el.data('prev-value') !== $el.val()) {
						$elVal.data('prev-value', $elVal.val());
						$elVal.val('');
					}
					else $elVal.val($elVal.data('prev-value'));
				});
			}
		}
	});
}

