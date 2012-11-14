<?php

/**
 * A simple tree dropdown field. Avoids all use of javascript.
 *
 * @author Simon Elvery
 */
class SimpleTreeDropdownField extends DropdownField {
	
	private $filterCallback;
	protected $keyField, $labelField, $sourceObject;
	
	public function __construct($name, $title = null, $sourceObject = 'SiteTree', $keyField = 'ID', $labelField = 'Title') {
		
		try {
			$obj = singleton($sourceObject);
		} catch (ReflectionException $e) {
			throw new InvalidArgumentException(sprintf('The \'%s\' class specified as the $sourceObject does not exist.', $sourceObject), $e->getCode(), $e);
		}
		
		if (!$obj->hasExtension('Hierarchy')) throw new InvalidArgumentException (sprintf('The $sourceObject class (\'%s\') must implement the Hierarchy extension.', $sourceObject));
		if (!$obj->hasField($keyField)) throw new InvalidArgumentException (sprintf('The %s class has no \'%s\' field.', $sourceObject, $keyField));
		if (!$obj->hasField($labelField)) throw new InvalidArgumentException (sprintf('The %s class has no \'%s\' field.', $sourceObject, $labelField));
		
		$this->sourceObject = $sourceObject;
		$this->labelField = $labelField;
		$this->keyField = $keyField;
		
		parent::__construct($name, $title, array());
	}
	
	/**
	 * Set a callback used to filter the values of the tree before 
	 * displaying to the user.
	 *
	 * @param callback $callback
	 */
	public function setFilterFunction($callback) {
		if(!is_callable($callback, true)) {
			throw new InvalidArgumentException('SimpleTreeDropdownField->setFilterCallback(): not passed a valid callback');
		}
		
		$this->filterCallback = $callback;
		return $this;
	}
	
	public function Field($properties = array()) {
		
		// Set the source
		$source = array();
		$objs = DataObject::get($this->sourceObject);
		foreach ($objs as $child) {
			if ( !$this->filterCallback || call_user_func($this->filterCallback, $child) ) {
				foreach ($this->compile_source($child) as $key => $label) {
					$source[$key] = $label;
				}
			}
		}
		$this->setSource($source);
		
		return parent::Field($properties);
	}
	
	/**
	 * Recursively add child objects to the tree.
	 * @param type $page
	 * @param type $options
	 * @param type $level
	 * @return type 
	 */
	private function compile_source($page, $options = array(), $level = 0) {
		foreach ($page->Children() as $child) {
			if ( !$this->filterCallback || call_user_func($this->filterCallback, $child) ) {
				$options[$child->{$this->keyField}] = str_repeat('-', $level) . ' ' . $child->{$this->labelField};
				$options = $this->compile_source($child, $options, $level++);
			}
		}
		return $options;
	}
	
}

?>
