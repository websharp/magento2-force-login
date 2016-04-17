# Magento2 Frontend Customer Force Login Module 

The Magento2 Frontend Customer Force Login Module redirects a visitor to the Magento2 Frontend login page. It is 
possible to overwrite the whitelisted urls to add custom definitions.

Installation
------------

The preferred way of installing `bitexpert/magento2-force-login` is through Composer. Simply add `bitexpert/magento2-force-login` 
as a dependency:

```
composer.phar require bitexpert/magento2-force-login
```

Example DI definition for custom definitions
--------------------------------------------

```xml
<type name="\bitExpert\ForceCustomerLogin\Controller\LoginCheck">
    <arguments>
        <argument name="ignoreUrls" xsi:type="array">
                <item name="admin_area" xsi:type="string">^/admin/?.*$</item>
                <item name="rest_api" xsi:type="string">^/rest/?.*$</item>
                <item name="customer_account_login" xsi:type="string">^/customer/account/login/?$</item>
                <item name="customer_account_logout" xsi:type="string">^/customer/account/logout/?$</item>
                <item name="customer_account_logout_success" xsi:type="string">^/customer/account/logoutSuccess/?$</item>
                <item name="customer_account_create" xsi:type="string">^/customer/account/create/?$</item>
                <item name="customer_account_create_password" xsi:type="string">^/customer/account/createPassword/?.*$</item>
                <item name="customer_account_forgot_password" xsi:type="string">^/customer/account/forgotpassword/?.*$</item>
                <item name="customer_account_forgot_password_post" xsi:type="string">^/customer/account/forgotpasswordpost/?.*$</item>
                <item name="customer_section_load" xsi:type="string">^/customer/section/load/?$</item>
                <item name="contact_us" xsi:type="string">^/contact/?$</item>
                <item name="help" xsi:type="string">^/help/?$</item>
        </argument>
        <argument name="targetUrl" xsi:type="string">customer/account/login</argument>
    </arguments>
</type>
```

License
-------

The Magento2 Frontend Customer Force Login Module is released under the Apache 2.0 license.
