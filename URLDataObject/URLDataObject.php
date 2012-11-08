<?php
/**
 * A decorator to give DataObjects a unique ULRSegment field.
 */
class URLDataObject extends DataExtension {
	
	static $db = array(
		'URLSegment' => 'Varchar(255)'
	);
	
	/**
	 * Support both Name and Title fields as possible fields to derive URLSegment from.
	 * 
	 * @return string
	 */
	private function getTitleField() {
		if ($this->owner->hasDatabaseField('Title')) return 'Title';
		if ($this->owner->hasDatabaseField('Name')) return 'Name';
		return 'ID';
	}

	/**
	 * Automatically generate and save a unique URLSegment for this record.
	 */
	public function onBeforeWrite(){
		
		$titleField = $this->getTitleField();
		
		// No need if there already is one or the object hasn't been saved yet.
		if (strlen($this->owner->URLSegment) > 0 || strlen($this->owner->$titleField) == 0) return;
		
		$t = URLSegmentFilter::create()->filter(trim($this->owner->$titleField));

		if (!$t || $t == '-' || $t == '-1' || $titleField == 'ID') { // Fallback to generic page name if path is empty (= no valid, convertable characters)
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
		
		// The DataObject being decorated must provide a getBaseLink function.
		if (!$this->owner->hasMethod('getBaseLink')) {
			throw new Exception(_t('URLDataObject.BaseLinkException','The DataObject being decorated must provide a getBaseLink function.'));
		}
		
		$baseLink = $this->owner->getBaseLink();
		
		$url = (strlen($baseLink) > 36) ? "..." .substr($baseLink, -32) : $baseLink;
		$urlsegment = new SiteTreeURLSegmentField('URLSegment', _t('URLDataObject.URLFieldLabel', 'URL Segment'));
		$urlsegment->setURLPrefix($url);
		if(!URLSegmentFilter::$default_allow_multibyte) {
			$urlsegment->setHelpText(_t('URLDataObject.HelpChars', 'Special characters are automatically converted or removed.'));
		}
		
		$titleField = $this->getTitleField();
		if ($titleField == 'ID') { // At the top if there's no title field.
			$fields->shift($urlsegment);
		} else {
			$fields->insertAfter($urlsegment, $titleField);
		}
		
		// Fix a but in CMS todo: remove when pull request is applied to core and released
		Requirements::add_i18n_javascript(CMS_DIR . '/javascript/lang', false, true);
		Requirements::css(CMS_DIR . "/css/screen.css");
		
        return $fields;
	}
}