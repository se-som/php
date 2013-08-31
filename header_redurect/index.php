<?php

echo '<a href="http://www.w3schools.com/tags/att_iframe_height.asp">go to</a>';




echo 'hello';
die();
$domain = $_SERVER["HTTP_HOST"];
var_dump($domain);
$uri = $_SERVER["REQUEST_URI"];
var_dump($uri).
$url = $domain . $uri;
 
if (($url == "redjohnsoncandy.com/") ||
   ($url == "www.redjohnsoncandy.com/")) { 
   header("Status: 301 Moved Permanently");
   header("Location: http://www.redjohnsoncandy.com/index.php?option=com_content&view=category&layout=blog&id=3&Itemid=12"); 
}
var_dump($url);
?>
