## Documentation

- Installation guide: https://www.mageplaza.com/install-magento-2-extension/ 
- User Guide: https://docs.mageplaza.com/shop-by-brand-m2/index.html
- Product page: https://www.mageplaza.com/magento-2-shop-by-brand/
- FAQs: https://www.mageplaza.com/faqs/
- Get Support: https://mageplaza.freshdesk.com/ or support@mageplaza.com
- Changelog: https://www.mageplaza.com/releases/shop-by-brand
- License agreement: https://www.mageplaza.com/LICENSE.txt


## How to install

Install ready-to-paste package (Recommended)

- Installation guide: https://www.mageplaza.com/install-magento-2-extension/#solution-1-ready-to-paste


## How to upgrade

1. Backup
Backup your Magento code, database before upgrading.
2. Remove Shopbybrand folder 
In case of customization, you should backup the customized files and modify in newer version. 
Now you remove `app/code/Mageplaza/Shopbybrand` folder. In this step, you can copy override Shopbybrand folder but this may cause of compilation issue. That why you should remove it.
3. Upload new version
Upload this package to Magento root directory
4. Run command line:

```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```



## FAQs


#### Q: I got error: `Mageplaza_Core has been already defined`
A: Read solution: https://github.com/mageplaza/module-core/issues/3

#### Q: My site is down
A: Please follow this guide: https://www.mageplaza.com/blog/magento-site-down.html

#### Q: How to insert brands in homepage, mega menu?
A: Please follow this guide: https://www.mageplaza.com/magento-2-shop-by-brand/show-brand-on-home-page.html

#### Q: Shop by brand Alphabet
A: Please follow this guide: https://www.mageplaza.com/magento-2-shop-by-brand/alphabet.html



## Support

- FAQs: https://www.mageplaza.com/faqs/
- https://mageplaza.freshdesk.com/
- support@mageplaza.com


