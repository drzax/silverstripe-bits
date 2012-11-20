<?php

/**
 * Extend the SiteTree to automatically publish versioned associated DataObjects.
 * 
 * @author Simon Elvery
 */
class VersionedDataObjects extends DataExtension {
	
	/**
	 * Correctly publish or delete versioned objects related to SiteTree.
	 */
	public function onBeforePublish() {
		
		// Get all the related components which are versioned.
		$versioned = array();
		foreach (array_unique(array_merge($this->owner->has_many(),$this->owner->many_many())) as $relationship => $class) {
			if ( singleton($class)->hasExtension('Versioned') ) $versioned[] = $relationship;
		}
		
		// Exclude versions dataobject from this situation
		$versioned = array_diff($versioned, array('Versions'));
		
		// No need if there aren't any versioned relations.
		if ( empty($versioned) ) return;
		
		// Temporarily change the mode
		$mode = Versioned::get_reading_mode();
		Versioned::set_reading_mode('Stage.Live');
		
		// Remove the live versions.
		// There should be a better way to do this, but it's beyond me right now.
		foreach ($versioned as $relationship) {
			$live = $this->owner->$relationship();
			if ($live) {
				foreach($live as $obj) {
					$obj->delete();
				}
			}
		}
		
		// Revert the mode and clear component cache.
		Versioned::set_reading_mode($mode);
		$this->owner->componentCache = array();

		// Publish the drafts. 
		foreach ($versioned as $relationship) {
			if ($related = $this->owner->$relationship()) {
				foreach($related as $obj) {
					$obj->publish('Stage', 'Live');
				}
			}
		}
		
		// Job done.
	}
}