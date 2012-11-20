VersionedDataOjbects
====================

A [DataExtension](http://docs.silverstripe.org/framework/en/reference/dataextension) which automatically publishes related (one-many and many-many)
data objects when a [SiteTree](http://docs.silverstripe.org/framework/en/reference/sitetree) object is published.

Usage
-----

Copy the `VersionedDataObjects.php` file to your project and make sure it's applied to SiteTree like so:

Either in `_config.php`:

```php
Object::add_extension('MyDataObject', 'VersionedDataObjects');
```

Or in `_config\extensions.yml`:

```yml
SiteTree:
  extensions:
    ['VersionedDataObjects']
```

Requirements
------------

Silverstripe 3.0+