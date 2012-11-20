VersionedModelAdmin
===================

A [DataExtension](http://docs.silverstripe.org/framework/en/reference/dataextension) which provides a UI for versioned 
[DataObjects](http://docs.silverstripe.org/framework/en/reference/dataobject) in [ModelAdmin](http://doc.silverstripe.org/framework/en/reference/modeladmin)

Usage
-----

Copy the `VersionedModelAdmin.php` file to your project and make sure it's applied to ModelAdmin like so:

Either in `_config.php`:

```php
Object::add_extension('ModelAdmin', 'VersionedModelAdmin');
Object::add_extension('GridFieldDetailForm_ItemRequest', 'VersionedModelAdmin_GridFieldDetailForm_ItemRequest');
```

Or in `_config\extensions.yml`:

```yml
ModelAdmin:
  extensions:
    ['VersionedModelAdmin']
GridFieldDetailForm_ItemRequest:
  extensions:
    ['VersionedModelAdmin_GridFieldDetailForm_ItemRequest']
```

Requirements
------------

Silverstripe 3.0+