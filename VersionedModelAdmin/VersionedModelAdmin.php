<?php

/**
 * Adds a 'Save & Publish' button to model admin where the dataobject being managed
 * has the Versioned extension.
 *
 * @author Simon Elvery
 */
class VersionedModelAdmin extends Extension {
	
	/**
	 * Modify the form actions
	 * @param Form $form The detail form
	 */
	public function updateEditForm($form) {
		
		if ( ! singleton($this->owner->modelClass)->hasExtension('Versioned') ) return;
		
		$gridField = $form->Fields()->fieldByName($this->sanitiseClassName($this->owner->modelClass));
		$gridField->getConfig()->getComponentByType('GridFieldDetailForm')->setItemEditFormCallback(function ($form) {
			$form->Actions()->push(FormAction::create('doPublish', 'Save & Publish'));
		});
	}
	
	/**
	 * Sanitise a model class' name for inclusion in a link
	 * @return string
	 */
	protected function sanitiseClassName($class) {
		return str_replace('\\', '-', $class);
	}
}

/**
 * Extend the GridFieldDetailForm_ItemRequest class to handle a publish action.
 */
class VersionedModelAdmin_GridFieldDetailForm_ItemRequest extends Extension {
	/**
	 * Handle the publish action.
	 * 
	 * @param $data array The form data.
	 * @param $form Form The form object.
	 */
	public function doPublish($data, $form) {
		$return = $this->owner->doSave($data, $form);
		$this->owner->record->publish('Stage', 'Live');
		return $return;
	}
	
}