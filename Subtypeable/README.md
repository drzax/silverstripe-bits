SubTypeable
===========

**Note:** This is somewhat incomplete documentation, although the class does work.

A [DataObjectDecorator](http://docs.silverstripe.org/framework/en/2.4/reference/dataobjectdecorator) which provides a `get_class_dropdown` method to 
[DataObject](http://docs.silverstripe.org/framework/en/2.4/reference/dataobject)s which can be used to display a list of possible object 
subtypes in the CMS.

Usage
-----

Copy the `SubTypeable.php` file to your project and apply to DataObjects which have sub-types.

Add the following to `_config.php`

```php
Object::add_extension('SubtypedDataObject', 'SubTypeable');
```

Or add an extensions static to your DataObject class

```php
public static $extensions = array(
	'SubTypeable'
);
```

Requirements
------------

Silverstripe 2.4.x