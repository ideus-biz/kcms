function generalInit(context)
{
	// See vendor kcms/package, module active, file: resources/assets/base/js/active/helpers.js
	inputMasquerading(context);
	initUploaders(context);
	initDatepicker(context);
	initTab(context);
	initTooltip(context);
	initAutoHeight(context);
    initPaginationScroll(context);
}

$(document).ready(function () {
});

$(window).on('load', function () {
});

$(window).on('kcmsReady', function() {
	generalInit();
	initListFilter();
	initListPrinting();

	ActiveWidget.EventOn('activated', function (widget) {
		generalInit(widget.context);

		initSelectPlugin(widget.context);
		initFormStyler(widget.context);
		initTab(widget.context);
	});

	ActiveList.EventOn('activated', function (form) {
		const $el = $('.js-tabLink[href="'+location.hash+'"]', form.domElement);
		if (location.hash && $el.length) selectTab($el);
	});

	ActiveForm.EventOn('activated', function (form) {
		const $el = $('.js-tabLink[href="'+location.hash+'"]', form.domElement);
		if (location.hash && $el.length) selectTab($el);
	});

	ActiveForm.Find('', '.js-context-form').first(form => {
		form.eventOn('result', (form, data) => {
			if (form.submittedBy?.attr('name') === 'savestay' && (data.reload??null))
			{
				//history.replaceState(null, '', data.reload+location.hash);
				location.href = data.reload+location.hash;
			}
		});
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

	if (!context?.length || context.parent().is('.js-context-form'))
	{
		if (location.hash && $('.js-tabContent'+location.hash).length)
		{
			const $el = $('.js-tabLink[href="'+location.hash+'"]');
			if ($el.length) selectTab($el);
		}
	}
}
//


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
			changeMonth: true,
			changeYear: true,
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


/**
 * Textarea auto height
 */
function initAutoHeight(context) {
	autosize($('.field-multilines'));
}


/**
 * init pagination scroll
 */
function initPaginationScroll(context) {
    $('.b-pagination__list a').on('click', function (){
        $([document.documentElement, document.body]).animate({
            scrollTop: $('.b-table').offset().top
        }, 400);
    });
}


function initListPrinting()
{
	ActiveList.Find('', '.js-context-list').first(list => {
		list.eventOn('afterAction', (list, action) => {
			//
			if (action.kcms('name') === 'print')
			{
				window.addEventListener('afterprint', (event) => {
					setTimeout(200);
					list.load();
				}, {once: true});
				
				list.eventOnce('activated', ()=>{
					setTimeout(() => {
						window.print();
					}, 200);
				});
			}
		});
	});
}
