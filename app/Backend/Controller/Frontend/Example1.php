<?php

namespace App\Backend;


/**
 * Class Controller Frontend Example1
 * 
 * Example1 controller
 * 
 * [!] Copy and paste this code to start your own controller
 * 
 */
class Controller_Frontend_Example1 extends \App\Backend\Controller
{
	
	/**
	 * Returns this controller general name
	 *
	 * This name is used in side menu and as the page header.
	 * Title can be dynamically changed in _buildMainMenu() method.
	 *
	 * @return string
	 */
	static public function SectionTitle(): string
	{
		return 'Example 1';
	}
	
	
	/**
	 * Returns this controller route name
	 *
	 * [!] Route name must be relative to the application.
	 *
	 * @return string
	 */
	static public function RouteName(): string
	{
		return 'frontend_example1';
	}
	
	
	/**
	 * Before list handler callback
	 * 
	 * This method called after common _beforeHandler() and before _action_list()
	 * 
	 * [*] Every handler has own before handler callback.
	 * 
	 * @return void
	 * @throws \Kcms\Core\Exception
	 */
	protected function _on_list()
	{
		if ($this->request->wantsHtml())
		{
			/*$this->eventOn('listCreated', function($self, $list){
				// Enable to set list's breadcrumbs
				// Menu::Instance('breadcrumbs')
				// 	->addItem('list')
				// 	->title('List');
				
				// Enable to set header for the list
				//$list->widget()?->header->title = 'List title';
				
				// Enable to use popups for adding and/or editing list data
				//$list->widget()?->editForm->usePopup(true);
				//$list->widget()?->addForm->usePopup(true);
			});*/
		}
	}
	
	
	/**
	 * Before edit handler callback
	 *
	 * This method called after common _beforeHandler() and before _action_edit()
	 *
	 * [*] Every handler has own before handler callback.
	 *
	 * @return void
	 * @throws \Kcms\Core\Exception
	 */
	protected function _on_edit()
	{
		if ($this->request->wantsHtml())
		{
			$this->eventOn('formCreated', function($self, $form) {
				// Enable to set form's breadcrumbs
				/*Menu::Instance('breadcrumbs')
					// First tail
					->addItem('list')
					->title('List')
					->target(Route::Url('frontend_example1'))
					// Next tail
					->menu
					->addItem('form')
					->title(!$form->isNew() ? 'Edit Example' : 'Add New Example');*/
				
				// Enable
				//$form->widget()?->form->title = 'Form title';
			});
		}
	}
	
}
