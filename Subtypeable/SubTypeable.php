<?php

/**
 * Provides a single relationship between sub-typed dataobjects. 
 */
class SubTypeable extends DataExtension {
	
	/**
	 * Get an array of subclass types suitable for a dropdown list.
	 * 
	 * @param string $type The class to get valid subclasses for.
	 * @return array An array of sub classes.
	 */
	public function get_class_dropdown($type) {
		
		$classes = ClassInfo::getValidSubClasses($type);
		
		// Remove base type type from the list of options.
		$baseClassIndex = array_search($type, $classes);
		if($baseClassIndex !== FALSE) unset($classes[$baseClassIndex]);
		
		$result = array();
		foreach ($classes as $class) {
			$instance = singleton($class);

			// If the current type is this the same as the class type always show the current type in the list
			if ($this->owner->ClassName != $instance->ClassName) {
				if((($instance instanceof HiddenClass) || !$instance->canCreate())) continue;
			}
			
			// Check for permission
			if($perms = $instance->stat('need_permission')) {
				if(!$this->owner->can($perms)) continue;
			}

			
			$typeName = _t($class.'.SINGULARNAME', $instance->singular_name());

			$currentClass = $class;
			$result[$class] = $typeName;
		}
		
		asort($result);
		if($currentClass) {
			$currentTypeName = $result[$currentClass];
			unset($result[$currentClass]);
			$result = array_reverse($result);
			$result[$currentClass] = $currentTypeName;
			$result = array_reverse($result);
		}
		
		return $result;
	}
	
}