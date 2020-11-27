# Magento 2 Shop By Brand GraphQL/PWA

[Mageplaza Shop By Brand for Magento 2](https://www.mageplaza.com/magento-2-shop-by-brand/) enables you to create a separate page to display brands that have products available in your store. 

With this kind of showcasing brands, customers who prefer shopping by brand will quickly find the brands they are looking for. When customers type in some first character of their favorite brand in the instant search box, the suggested brands will appear at the drop-down, so you can swiftly pick up your favorite and go to more details of the brand. 

With each brand page, there will be essential information included, such as brand description, product description, price, rating, and other attributes. Brand logos can be displayed on the product page as well so that it’s easier for customers to identify their favorite brands. Shop By Brand is integrated with Mageplaza Layered Navigation. Customers can use brand as a product attribute to filter the products they want to buy from a specific brand. 

Based on your store’ scale and customers’ demand, you can add as many brands as you want to your store's brand page at once without manual processing one by one. You only need one click to bulk import various brands via a CSV file. The brands will be updated automatically to the brand page with complete information and brand images. 

The extension supports you in creating brand listing and brand pages with SEO-friendly URL and custom meta tags. Your pages will be more likely to rank higher on the search engine results page and let more customers know about this exciting feature of your store. 

A good news is that **Magento 2 Shop By Brand GraphQL is now a part of Mageplaza Shop By Brand extension that supports GraphQL features.** This supports PWA compatibility with a lot of advantages and convenience. The extension supports getting and pushing data on the website with GraphQl, this support for PWA Studio.

## 1. How to install

Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-shop-by-brand-graphql
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

**Note:**
Mageplaza Shop By Brand GraphQL requires installing [Mageplaza Shop By Brand](https://www.mageplaza.com/magento-2-shop-by-brand/) in your Magento installation.

## 2. How to use

To perform GraphQL queries in Magento, please do the following requirements:

- Use Magento 2.3.x or higher. Set your site to [developer mode](https://www.mageplaza.com/devdocs/enable-disable-developer-mode-magento-2.html).
- Set GraphQL endpoint as `http://<magento2-server>/graphql` in url box, click **Set endpoint**. 
(e.g. `http://dev.site.com/graphql`)
- To view the queries that the **Mageplaza Shop By Brand GraphQL** extension supports, you can look in `Docs > Query` in the right corner

## 3. Devdocs

- [Shop By Brand API & examples](https://documenter.getpostman.com/view/10589000/SzRxXr2x?version=latest)
- [Shop By Brand GraphQL & examples](https://documenter.getpostman.com/view/10589000/SzRxXr2y?version=latest)

Click on Run in Postman to add these collections to your workspace quickly.

![Magento 2 blog graphql pwa](https://i.imgur.com/lhsXlUR.gif)

## 4. Contribute to this module

Feel free to **Fork** and contribute to this module and create a pull request so we will merge your changes main branch.

## 5. Get Support

- Feel free to [contact us](https://www.mageplaza.com/contact.html) if you have any further questions.
- Like this project, Give us a **Star** ![star](https://i.imgur.com/S8e0ctO.png)
