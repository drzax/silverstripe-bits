<?php

/**
 * A data object extension which enforces that only one instance of the extended 
 * page type can be created. Also provides some utility funcitons for working
 * with signleton page types.
 */
class SingletonPage extends DataExtension {
	
	/**
	 * Extend the can create method to return false if there is already a page
	 * of this type.
	 * 
	 * @param Member $member The member being checked.
	 * @return boolean
	 */
	public function canCreate($member) {
		return (DataObject::get($this->owner->class)->count() > 0) ? false : parent::canCreate($member);
	}
	
	/**
	 * Get the one instance of the page type specified.
	 * @param string $type The class name of the SingletonPage object being requested.
	 * @return mixed The page object or null if none exists.
	 */
	public static function get($type) {
		// Check that the requested type is a SingletonPage
		if ( ! singleton($type)->hasExtension('SingletonPage') ) {
			user_error(_t('SingletonPage.UsageError', 'This method should only be used with page types decorated with the SingletonPage extension.'));
		}
		return DataObject::get_one($type);
	}
}