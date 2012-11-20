VersionedDataOjbects
====================

A [DataObjectDecorator](http://docs.silverstripe.org/framework/en/2.4/reference/dataobjectdecorator) which automatically publishes related (one-many and many-many)
data objects when a [SiteTree](http://docs.silverstripe.org/framework/en/2.4/reference/sitetree) object is published.

Usage
-----

Copy the `VersionedDataObjects.php` file to your project and make sure it's applied to SiteTree like so:

Either in `_config.php`:

```php
Object::add_extension('MyDataObject', 'VersionedDataObjects');
```

Requirements
------------

Silverstripe 2.4.x