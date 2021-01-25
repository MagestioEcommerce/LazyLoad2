# Magestio LazyLoad for Magento 2.4.+

[![N|Solid](https://magestio.com/wp-content/uploads/logo_web_r.png)](https://magestio.com)

### Features

* Simple lazyload for catalog list pages


### Installation

* Download the extension
* Unzip the file
* Create the directory app/code/Magestio/LazyLoad2
* Copy the files in this directory.


### Enable the extensions

```
php bin/magento module:enable Magestio_LazyLoad
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
php bin/magento setup:static-content:deploy
```

### Requirements

* Compatible with Magento 2.4.+
* This extension requires Magestio_Core extension [https://github.com/MagestioEcommerce/core](https://github.com/MagestioEcommerce/core)

### Technical support

* Web: [https://magestio.com/](https://magestio.com/)
