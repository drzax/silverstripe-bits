<?php
/**
 * A decorator to give DataObjects a unique ULRSegment field.
 */
class URLDataObject extends DataExtension {
	
	static $db = array(
		'URLSegment' => 'Varchar(255)'
	);

	/**
	 * Automatically generate and save a unique URLSegment for this record.
	 */
	public function onBeforeWrite(){
		
		// No need if there already is one
		if (strlen($this->owner->URLSegment) > 0 || strlen($this->owner->Title) == 0) return;
		
		$t = URLSegmentFilter::create()->filter(trim($this->owner->Title));

		if (!$t || $t == '-' || $t == '-1') { // Fallback to generic page name if path is empty (= no valid, convertable characters)
			$t = strtolower($this->owner->ClassName)."-{$this->owner->ID}";
		} else { 
			$count = 0;
			$t1 = $t;
			
			// Make sure this is unique within the dataobject.
			while ($object = DataObject::get_one($this->owner->ClassName, 'URLSegment = \'' . $t1.'\' AND ID != '.$this->owner->ID)) {
				$count++;
				$t1 = $t.'-'.$count;
			}
			$t = $t1;
		}

		$this->owner->URLSegment = $t;
	}

	/**
	 * Update the fields list to include the URL field
	 * @param FieldList $fields
	 * @return FieldList The updated fields.
	 */
	public function updateCMSFields(FieldList $fields) {
		
		$baseLink = Controller::join_links (
			Director::absoluteBaseURL(),
			($this->owner->PageID ? $this->owner->Page()->RelativeLink(true) : null)
		);
		
		$url = (strlen($baseLink) > 36) ? "..." .substr($baseLink, -32) : $baseLink;
		$urlsegment = new SiteTreeURLSegmentField('URLSegment', _t('URLDataObject.URLFieldLabel', 'URL for this record'));
		$urlsegment->setURLPrefix($url);
		if(!URLSegmentFilter::$default_allow_multibyte) {
			$urlsegment->setHelpText(_t('URLDataObject.HelpChars', ' Special characters are automatically converted or removed.'));
		}
		
		$fields->insertAfter($urlsegment, 'Title');

        return $fields;
	}
}