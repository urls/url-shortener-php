# url-shortener
==============
It is a small set of PHP scripts that will help you in shortening your url by which you can get a more precised version of your url at ease.

#DATABASE USED
===============
--Database Name : urls
  -- Table name : Link
    --with some sample inputs


              |     id        |      url           |  Code     |       Created       |
              | ------------- |:------------------:|:---------:|--------------------:|
              |       1       |http://amarpandey.ml|   5yc1u   | 2016-01-29 23:46:41 |
              |       2       |http://amar.com     |   5yc1w   | 2016-01-29 23:46:41 |
              |       3       |http://yahoo.com    |   5yc1x   | 2016-01-29 23:46:41 |
              |       4       |http://github.io    |   5yc1y   | 2016-01-29 23:46:41 |


Basic UI :
![url-shortener](https://raw.githubusercontent.com/amarlearning/url-shortener/master/img/imageone.jpg)


Enter the domain in the input box. In order to find whether a url is valid or invalid there are two check avilable.
one is the inbuilt check of HTML5 (type="email") this by default checks the validity of url and the other is the manual check using php (FILTER_VALIDATE_URL).

![url-shortener](https://raw.githubusercontent.com/amarlearning/url-shortener/master/img/imagethree.jpg)


If all the things worked correctly, then you will get output something like this :
![url-shortener](https://raw.githubusercontent.com/amarlearning/url-shortener/master/img/imagetwo.jpg)
