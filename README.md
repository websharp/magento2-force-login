# Force Login for Magento2

The *Force Login* Module for **Magento2** redirects a storefront visitor to the store's login page, 
if the visitor is not logged in. It is possible to configure some whitelisted urls to allow explicit pages to be accessable by visitors.

## Use Case

Merchants provide some closed up products for only a specific group of users, e.g. enterprise related business partners and must assure only these partners can see the website or the product catalog.

## Features:

* Force your guest visitors to log in first (or register), before allowing them to visit your pages and catalog
* Administration: Manage the whitelist rules by the GUI in the administration area
* ACL: Restrict the administration of whitelist rules to certain backend user groups
* Whitelisting: Define url rules as pattern to define which pages guest visitors can visit without logging in first
* Multistore-Support: Define if whitelist rules either apply globally or for specific stores

## Installation

The preferred way of installing `bitexpert/magento2-force-customer-login` is through Composer. Simply add `bitexpert/magento2-force-customer-login` 
as a dependency:

```
composer.phar require bitexpert/magento2-force-customer-login
```

## How to configure the module

### Navigation

Navigating through the *Magento 2* backend menu by clicking onto **Customers** you must see a new menu entry **Forced Login Whitelist**. 
Enter this menu entry.

![alt text](./resources/ui_step_01.png "UI Navigation")

### Overview Grid

You can add new entries by clicking on the *Add Entry* button in the upper right corner ( **1** ), [see below](#detail-form). 
The grid ( **2** ) contains all existing whitelisted *Url Rules*, for which the forced redirect to the *Customer Login Page* is omitted.
The *Url Rules* ( **3** ) are part of a regular expression checking on the called *Url* and tries to match against the whitelist.
*Url Rules* may be related to all stores or to a specific one ( **4** ). All rules except some mandatory ones are editable ( **5** ) and removeable ( **6** ).

![alt text](./resources/ui_step_02.png "UI Grid")

### Detail Form

You can return to the *Overview Grid* by using the *Back* button ( **1** ). The *Label* value has only declarative character and
is for information purpose only ( **2** ). The *Url Rule* is part of a regular expression checking on the called 
*Url* and tries to match against the whitelist ( **3** ). *Url Rules* may be related to all stores or to a specific one ( **4** ).
Persist the rule by using the *Save* button ( **5** ).

![alt text](./resources/ui_step_03.png "UI Form")

## Contribution

Feel free to contribute to this module by reporting issues or create some pull requests for improvements.

## License

The Force Login module for Magento2 is released under the Apache 2.0 license.
