# Painter's portfolio website with a shop 
 
Project's URL:  *https://rosiepiontek.com*

## Content

* Presentation of painter's artwork
* Contact form 
* Shop

## Technologies used

* Apache, MySQL, PHP 8.0.18

* pure JavaScipt, jQuery  
   
* PayPal API with the Smart Button  
*https://developer.paypal.com/docs/checkout/integrate/*  
*https://developer.paypal.com/docs/checkout/reference/server-integration/capture-transaction/*  
*https://developer.paypal.com/demo/checkout/#/pattern/server*

* PHP Mailer  

* Composer

## Visual third-party components  

* Google fonts and icons

* Icons from *https://fontawesome.com/*

* Hamburger icon for activating main menu on touchscreens narrower than 1170px
*https://jonsuh.com/hamburgers/*

* Fotorama image gallery for displaying photos of products in the shop on touchscreens narrower than 1170px
*https://fotorama.io/*

## General description

The idea was to use the MVC pattern in this project without a framework.  
There are controllers, services and dependency containers which pass services to controllers.

All requests are passed to *index.php*.

Main components are located in *views* folder.  Smaller parts which are included in the main components are located in *includes*.

JavaScript code uses ES6 modules imported dynamically.

Database is queried using MySQL stored procedures or prepared statements.

Website can be fully keyboard-only navigated.

## Shop description


Online payment uses PayPal Smart Button integrated on the sever side.

When order is created and sent to PayPal all its details are also stored in a PHP session superglobal which upon successful capturing of the transaction is used for further processing (database insertion and sending purchase confirmation to the client).

Stock is fully controlled.
Number of products available always reflects the stock amount in the database which gets automatically updated after a completed purchase.  
If the quantity of a product which is to be added to the basket is going to be greater than the stock amount, a notification will appear, saying how many copies of a particular product user has tried to add and how many are currently available. In such case the amount automatically added to the basket will be the maximum quantity available in the stock.

## Website structure

```
Homepage with
thumbnail* images ---------------------------------------
of all works        |            |       |       |     |
                    |            |       |       |     |
                    |          About  Contact  Shop  Basket
              Subnavigation
              with links to 
              artwork sections
              showing thumbnail images

* Each thumbnail image opens a full-page slideshow gallery lightbox with larger versions of the images.
``` 


## Future improvements  

 [x] Load Fotorama gallery plug-in only for touchscreens narrower than 1170px.

 [x] Find a working hack for blurred images in Chrome in the slideshow gallery.

 [ ] Prepared statements instead of MySQL stored procedures.

 [ ] reCAPTCHA in the contact form.

 [ ] Automatic email notification sent to the seller when stock is low.  

 [ ] In a situation when clicking browser's back button (while the full-page lightbox gallery is open) would take the user to a different website, a warning should appear. Plug-in for implementing it: https://github.com/codedance/jquery.AreYouSure .  

 [ ] Same warning (as above) in the basket when it's not empty.

 [ ] When user submits the contact form, a notification above it saying "Sending...", in the same place where "Message sent. Thank you" is displayed later.

 [ ] An animated placeholder for images being loaded in the lightbox gallery.



## Hacks used  

'image-rendering: pixelated' for images in the slideshow gallery when they are not shown in full-page to give illusion of sharpness. Chrome does not render downscaled images without blurring them.
