SimpleTreeDropdownField
=======================

A [FormField](http://docs.silverstripe.org/framework/en/reference/formfield) which provides a simple, flexible tree dropdown field.

The [TreeDropdownField](http://api.silverstripe.org/3.0/forms/fields-relational/TreeDropdownField.html) provided by the Silverstripe framework core
is great for use in the backend, but it's too heavily coupled and uses javascript where maybe it shouldn't. This provides a simple, but flexible
alternative for use where the TreeDropdownField isn't suitable.

Usage
-----

Drop the class into your project code directory and flush so the class manifest gets rebuilt, then use in your forms as below.

```php
SimpleTreeDropdownField::create('Page', _t('Form.PageLabel', 'Select a page?'));
```

The constructor takes three optional parameters in addition to the standard `$name` and `$title` which almost all Silverstripe form fields take. They are:

* `$sourceClass` (default: `SiteTree`) - The class to use as the source for items in the tree. This class must implement the Hierarchy extension.
* `$keyField` (default: `ID`) - The field to use in the `value` attribute of the resulting dropdown field options.
* `$labelField` (default: `Title`) - The field to display as the dropdown options.

A filter callback can be set as follows.

```php
$field->setFilterFunction(array($this,'filter'));
```

The callback function will be passed the DataObject and should return `true` if the item should be included and `false` if it should be excluded. For example:

```php
public function filter ($obj) {
	return ($obj->IncludeInDropdown == 'Yes');
}
```

Requirements
------------

Silverstripe 3.0+