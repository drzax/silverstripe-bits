URLDataObject
=============

A [DataObjectDecorator](http://docs.silverstripe.org/framework/en/2.4/reference/dataobjectdecorator) which gives any 
[DataObject](http://docs.silverstripe.org/framework/en/2.4/reference/dataobject) a unique URLDataObject field similar to all descendents of SiteTree.

Usage
-----

Copy the `URLDataObject.php` file to your project and apply to the DataObjects of your choice in one of the following ways.

Add the following to `_config.php`

```php
Object::add_extension('MyDataObject', 'URLDataObject');
```

Or add an extensions static to your DataObject class

```php
public static $extensions = array(
	'URLDataObject'
);
```

Requirements
------------

Silverstripe 2.4.x