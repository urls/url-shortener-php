# URL SHORTENER
It is a small set of PHP scripts that will help you in shortening your url by which you can get a more precised version of your url at ease.

##DATABASE USED
<ul>
  <li>Database Name : urls</li>
  <li>Table name : Link</li>
  <li>with some sample inputs</li>
</ul>              
  <table>
    <tr>
      <td>id</td>
      <td>url</td>
      <td>Code</td>
      <td>Created</td>
    </tr>
    <tr>
      <td>1</td>
      <td>http://amarpandey.me</td>
      <td>5yc1u</td>
      <td>2016-01-29 23:46:41</td>
    </tr>
    <tr>
      <td>2</td>
      <td>http://amar.com </td>
      <td>5yc1v</td>
      <td>2016-01-29 23:47:57</td>
    </tr>
    <tr>
      <td>3</td>
      <td>http://yahoo.com</td>
      <td>5yc1w</td>
      <td>2016-01-29 23:49:32</td>
    </tr>
    <tr>
      <td>4</td>
      <td>http://github.io</td>
      <td>5yc1x</td>
      <td>2016-01-29 23:52:12</td>
    </tr>
  </table>


**Basic UI :**
![url-shortener](https://raw.githubusercontent.com/urls/url-shortener/master/img/imgone.jpg)

```
Enter the domain in the input box. In order to find whether a url is valid or invalid there are two check avilable.
one is the inbuilt check of HTML5 (type="email") this by default checks the validity of url and the other is the manual check using php (FILTER_VALIDATE_URL).
```

![url-shortener](https://raw.githubusercontent.com/urls/url-shortener/master/img/imagethree.jpg)

**If all the things worked correctly, then you will get output something like this :**
![url-shortener](https://raw.githubusercontent.com/urls/url-shortener/master/img/imagetwo.jpg)

