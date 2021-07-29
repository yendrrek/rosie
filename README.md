# Painter's portfolio website with a shop 

This is my debut project which I started in November 2019 to learn web development and design.  
Project's address:  *https://rosiepiontek.com*

## Content

* Presentation of the painter and her artwork in a form of thumbnail images and more detailed full-page slideshow gallery with short description of each artwork
* Contact form 
* Shop selling greetings cards based on some of the artwork

## Technologies used

* Apache, MySQL, PHP 7.1

* jQuery  for Ajax calls when processing the basket and the contact form
   
* PayPal API with the Smart Button  
*https://developer.paypal.com/docs/checkout/integrate/*  
*https://developer.paypal.com/docs/checkout/reference/server-integration/capture-transaction/*  
*https://developer.paypal.com/demo/checkout/#/pattern/server*

* PHP Mailer for sending purchase confirmation to clients  

* Composer dependency manager for installing PayPal SDK and PHP Mailer

### Visual third-party components  

* Google fonts and icons

* Icons from *https://fontawesome.com/*

* Animated hamburger icon for activating main menu on touchscreens narrower than 1170px
*https://jonsuh.com/hamburgers/*

* Fotorama image gallery for displaying photos of products in the shop on touchscreens narrower than 1170px
*https://fotorama.io/*

## General description

This project uses MVC pattern.

There is one central controller (*index.php*) via which all other pages are loaded.

Main components are located in *views* folder.  Smaller parts which are included in the main components are located in *includes*.

PHP code uses classes.

JavaScript code uses ES6 modules with object literals which are imported to *main.js*.

Contact form is validated and sanitised on the server side.

In some cases insertion into database or fetching data from it is performed using MySQL stored procedures. These cases are:  
&nbsp;&nbsp;&nbsp;&nbsp;a) basket operations (adding, removing products);  
&nbsp;&nbsp;&nbsp;&nbsp;b) pulling images of the artworks and their descriptions.

Prepared statements are used for database insertion of:  
&nbsp;&nbsp;&nbsp;&nbsp;a) user input from the contact form;  
&nbsp;&nbsp;&nbsp;&nbsp;b) completed orders and customer details.
  
Nonces and Content Security Policy headers are applied with PHP to increase security of the website.

Environment variables are used to hide all sensitive data and to distinguish between development and production environment in code related with the shop.

Website can be fully keyboard-only navigated.

## Shop description

All operations are performed using AJAX for a smooth user experience and their results are recorded in the database (adding, removing products, updating quantity, order and customer details).

Online payment is possible via PayPal Smart Button integrated on the sever side.

When order is created and sent to PayPal all its details are also stored in a PHP session superglobal which upon successful capturing of the transaction is used for further processing (database insertion and sending purchase confirmation to the client).

Stock is fully controlled.
Number of products available always reflects the stock amount in the database which gets automatically updated after a completed purchase.  
If the quantity of a product which is to be added to the basket is going to be greater than the stock amount, a notification will appear, saying how many copies of a particular product user has been trying to add, and how many are currently available. In such case the amount automatically added to the basket will be the maximum quantity available in the stock.

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

 [ ] Load JavaScript modules only when they are needed.

 [ ] Prepared statements instead of MySQL stored procedures.

 [ ] reCAPTCHA in the contact form.

 [ ] Automatic email notification sent to the seller when stock is low.  

 [ ] In a situation when clicking browser's back button (while the full-page lightbox gallery is open) would take the user to a different website, a warning should appear. Plug-in for implementing it: https://github.com/codedance/jquery.AreYouSure .  

 [ ] Same warning (as above) in the basket when it's not empty.

 [ ] When user submits the contact form, a notification above it saying "Sending...", in the same place where "Message sent. Thank you" is displayed later.

 [ ] An animated placeholder for images being loaded in the lightbox gallery.

 [ ] Progressive enhancement. Better functionality without JavaScript.

 [ ] Server-side automatic minification.

 [ ] The following refers to Chrome only: Faster rendering of the images when they are seen first time in the lightbox gallery. Event though they are all cached when the lightbox is open for the first time, the initial rendering is slower. When navigating to the same image again, it renders faster. 

 [ ] Hover effect stays active on a thumbnail image when closing the slideshow gallery lightbox.


## Hacks used  

'image-rendering: pixelated' for images in the slideshow gallery when they are not shown in full-page to give illusion of sharpness. Chrome is not able to render downscaled images without blurring them.
