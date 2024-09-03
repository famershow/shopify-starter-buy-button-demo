# Shopify Starter Buy Button List
This will allow you to display all products in your Shopify STARTER plan. Regular Shopify plans offer an option to do this automatically, but the Starter plan does not as categories are disabled.

This script also has fallbacks in case of loading troubles, so users can at least still get to your direct shop if there is poor internet or if they have scripts disabled.

Example: https://deguarts.com/shop/pins-keychains-more/ 

## Steps
First, you will need to add the Buy Button app to your store: https://apps.shopify.com/buy-button

Next, create a Product Buy Button (select any product, it doesn't matter at this point other than a preview).

Choose the following:
- Layout style: Classic
- Action when people click: Open product details
- Set your button styles, layout, shopping cart, and detailed pop-up how you'd like
- Under advanced settings, I recommend "Redirect in the same tab"

Click Next and within the code they give, you need to grab the following:
- storefrontAccessToken, around line 25
- everything within the options: {} variable, should be around line 33 - 301

In the shop.php script I've provided, you need to update the following:
- shopifyurl needs to be set to your myshopify url. If you don't know what this is, go to Settings --> Domains and use the XXXXX.myshopify.com url.
- accesstoken needs to be tto the storefrontAccessToken you copied from the buy button script.
- var options = {XXXXXXX} around line 77. Update XXXXXXX with the options you copied from the buy button script.

And you're set! Include the script on your website (PHP preferred for variables, but can be changed to regular HTML buy coping those variables into their correct locations) and adjust the styles as you wish (I set a basic style.css for you).

[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/G2G811062)
