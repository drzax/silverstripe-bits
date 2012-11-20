SubTypeable
===========

**Note:** This is somewhat incomplete documentation, although the class does work.

A [DataExtension](http://docs.silverstripe.org/framework/en/reference/dataextension) which provides a `get_class_dropdown` method to 
[DataObject](http://docs.silverstripe.org/framework/en/reference/dataobject)s which can be used to display a list of possible object 
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

Or via `_config/extension.yml`:

```yml
SubtypedDataObject:
  extensions:
    ['SubTypeable']
```

Requirements
------------

Silverstripe 3.0+