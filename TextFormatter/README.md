TextFormatter
=============

A [DataExtension](http://docs.silverstripe.org/framework/en/reference/dataextension) which gives any Text field two 
additional template formatting functions.

Usage
-----

Copy the `TextFormatter.php` file to your project and apply to the Text class.

```yaml
Text:
  extensions:
    ['TextFormatter']
```

You can now use `$FieldName.NL2BR` and `$FieldName.NL2P' in your templates to turn line breaks into `<br>` tags and
new paragraphs respectively.

Requirements
------------

Silverstripe 3.0+