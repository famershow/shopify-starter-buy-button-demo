<?php $shopifyurl = 'XXXXX.myshopify.com';
$accesstoken = 'XXXXXXXXXXXX'; ?>

<!-- Shop will load in here -->
<div id="shopload"><div class="shopify-all"></div></div>

<!-- If the user has disabled javascript, use a direct link to your shopify shop -->
<noscript><a href="https://<?=$shopifyurl?>">View My Shop</a></noscript>

<!-- This generates the shop -->
<script>
	$.ajax({
      url: 'https://<?=$shopify?>/api/graphql',
      method: 'POST',
      headers: {
          'X-Shopify-Storefront-Access-Token': '<?=$accesstoken?>',
  		  'Content-Type': 'application/graphql',
      },
      data: `query {
        products(first:100) {
          edges {
            node {
              id
              title
              variants(first: 1) {
                  edges {
                    node {
                      priceV2 {
                        amount
                      }
                    }
                  }
              } 
            }
          }
        }
      }`,
    })
    .done(function(data) {
        var productlist = [];
        $.each(data, function(key,products){
            $.each(products, function(key,edges){
                $.each(edges, function(key,i){
                    $.each(i, function(key,product){
                        $.each(product, function(key,node){
                            var title = node.title;
                            var id = node.id;
                            var ids = id.split("/");
                            var prodid = ids.pop();
                            var productArray = [prodid, title];
                            $.each(node.variants.edges, function(key,prices){
                                $.each(prices, function(key,price){
                                    productArray.push(price.priceV2.amount);
                                });
                            });
                            productlist.push(productArray);
                        });
                    });
                });
            });
        });

        productlist.sort((a, b) => {
          const priceComparison = parseFloat(b[2]) - parseFloat(a[2]);
          if (priceComparison === 0) {
            return a[1].localeCompare(b[1]);
          } else {
            return priceComparison;
          }
        });
        $.each(productlist, function(key,prod) {
            $('.shopify-all').append('<div class="shopify-all-single"><div id="product-component-'+prod[0]+'"></div></div>');
        });
        
        /*<![CDATA[*/
        (function () {
          var options = {XXXXXXX}; // COPY OPTIONS FROM BUY BUTTON SCRIPT GENERATOR
          var scriptURL = "https://sdks.shopifycdn.com/buy-button/latest/buy-button-storefront.min.js";
          if (window.ShopifyBuy) {
            if (window.ShopifyBuy.UI) {
              ShopifyBuyInit();
            } else {
              loadScript();
            }
          } else {
            loadScript();
          }
          function loadScript() {
            var script = document.createElement("script");
            script.async = true;
            script.src = scriptURL;
            (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(script);
            script.onload = ShopifyBuyInit;
          }
          function ShopifyBuyInit() {
            var client = ShopifyBuy.buildClient({
              domain: "<?=$shopify?>",
              storefrontAccessToken: "<?=$accesstoken?>",
            });
            var ui = ShopifyBuy.UI.init(client);
            
            $.each(productlist, function(key,prod) {
                ui.createComponent('product', {id: prod[0], node: document.getElementById('product-component-'+prod[0]), moneyFormat: '%24%7B%7Bamount%7D%7D', options: options});
            });
            $('#noload').hide();
          }
        })();
        /*]]>*/
    });
    setTimeout(function() {
        if ($('.shopify-all').children().length === 0) {
            $('#shopload').append('<p id="noload" style="text-align:center;margin-top:0;">Not loading? <strong><a href="https://<?=$shopifyurl?>" target="_blank" rel="noopener">Try this link!</a></strong></p>');
        }
    }, 5000);
</script>
