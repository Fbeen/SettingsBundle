# FbeenSettingsBundle

This Bundle adds global settings out of the database integration on top of the Symfony framework. It lets you design application-settings which can be maintained by the owner or administrator from the website. 

### Features include:

* Unlimmited setting fields
* Bootstrap ready pages and forms
* Settings can be made and deleted by you developer when you add yourself the ROLE_SUPER_ADMIN in a form
* The value of the setting fields can be changed by the users that have ROLE_ADMINISTRATOR in a form
* The value of the setting fields can be changed by the application
* Five formtypes: text, email, boolean, integer and decimal.
* Form validation dependend on the formtype.


## Installation

Using composer:

1) Add `"fbeen/settingsbundle": "dev-master"` to the require section of your composer.json project file.

```
    "require": {
        ...
        "fbeen/settingsbundle": "dev-master"
    },
```

2) run composer update:

    $ composer update

3) Add the bundle to the app/AppKernel.php:
```
        $bundles = array(
            ...
            new Fbeen\SettingsBundle\FbeenSettingsBundle(),
        );
```
4) add routes to app/config/routing.yml
```
fbeen_settings:
    resource: "@FbeenSettingsBundle/Resources/config/routing.yml"
    prefix:   /admin
```

5) add routes to app/config/routing_dev.yml
```
_fbeen_settings:
    resource: "@FbeenSettingsBundle/Resources/config/routing_dev.yml"
    prefix:   /admin
```

6) Enable Translation in `app/config/config.yml`
```
parameters:
    locale: en

framework:
    translator:      { fallbacks: ["%locale%"] }
```
7) Configure `app/config/security.yml` so that ROLE_ADMIN and ROLE_SUPER_ADMIN do exist:
```
security:

    # ...
                
    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: ROLE_ADMIN
```

8) Update your database schema
```
$ bin/console doctrine:schema:update --force
```
9) Login with an account that has ROLE_SUPER_ADMIN. 

10) Go to the route .../app_dev.php/admin/settings/developer and start to add settings. The form is very easy to use and does not require further explanations

11) Go to the route .../app_dev.php/admin/settings/edit and see how administrators can change values


## Usage

Imagine that you made a setting with the identifier shipping_price and that you want to use the setting in your controller:
```
$value = $this->get('fbeen_settings.settings_helper')->getSetting('shipping_price');
```
Or that you want to render the setting in Twig:
```
{{ setting('shipping_price') }}
```

Update a setting:
```
$this->get('fbeen_settings.settings_helper')->updateSetting('shipping_price', $price);
```
Or maybe you want to use a setting as a page-view counter:
```
$helper = $this->get('fbeen_settings.settings_helper');
$counter = $helper->getSetting('page_views');
$helper->updateSetting('page_views', ++$counter);
```
