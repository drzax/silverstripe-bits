SingletonPage
=============

A [DataExtension](http://docs.silverstripe.org/framework/en/reference/dataextension) which enforces that there is only one instance of a given page type.

Note that the use of 'singleton' here does not refer to use of the [singleton pattern](http://en.wikipedia.org/wiki/Singleton_pattern) as commonly understood in 
programming.

Usage
-----

### Decorate the page class

In `_config.php`:

```php
Object::add_extension('MyPage', 'SingletonPage');
```

Or in the class itself:

```php
public static $extensions = array(
	'SingletonPage'
);
```

### Override `canCreate` on the base Page class
Silverstripe core currently prevents DataExtensions from overriding the behaviour of the SiteTree->canCreate() function for users with ADMIN permissions (see 
[ticket](http://open.silverstripe.org/ticket/7986)), so an addition to adding the extension to the page type a modification to the Page class is also required 
to properly invoke this DataExtension.

```php
/**
 * Override the canCreate method to change the order of processing and allow
 * the SingletonPage DataExtension to do its work.
 */
public function canCreate($member = null) {
	if(!$member || !(is_a($member, 'Member')) || is_numeric($member)) {
		$member = Member::currentUserID();
	}

	// Standard mechanism for accepting permission changes from extensions
	$extended = $this->extendedCan('canCreate', $member);
	if($extended !== null) return $extended;

	return parent::canCreate($member);
}
```

Note that if your project only has one page type that needs to be a singleton it you can do all this just by overriding the `canCreate` method in that class and
there's no need for a DataExtension at all.

Requirements
------------

Silverstripe 3.0+