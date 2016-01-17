# ASTECHINDO (astech.co.id) Repair Order Status Auto Checker

This respository was made by me to help me to automatic check status repair order at ASTECHINDO (astech.co.id) or m-care based on Mal Roxy Square Blok B5 Jl Kyai Tapa No 1 Jakarta Barat.  

I'm too lazy to check my status order in http://astech.co.id:66/Default.aspx

## HOW TO

1. clone this repo & do `composer install`
2. put your mandrill username & api key in `src/crawler.php`, don't forget to change email destination
3. still in `src/crawler.php` change array value in `$mCareForm` with your repair order number.
4. add `src/crawler.php` in your cronjob
##testing
