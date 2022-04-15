<?php
!defined("DS") ? define("DS" , DIRECTORY_SEPARATOR) : DS;
!defined("BASE_PATH") ? define("BASE_PATH" , dirname(__FILE__ , 2).DS) : BASE_PATH;
!defined("APP_PATH") ? define("APP_PATH" , dirname(__FILE__ , 2).DS."App".DS) : APP_PATH;
!defined("VIEW_PATH") ? define("VIEW_PATH" , APP_PATH."Views".DS) : VIEW_PATH;
!defined("TEMPLATE_PATH") ? define("TEMPLATE_PATH" , APP_PATH."Template".DS) : TEMPLATE_PATH;
!defined("LANG_PATH") ? define("LANG_PATH" , APP_PATH."Lang".DS) : LANG_PATH;
!defined("PUBLIC_PATH") ? define("PUBLIC_PATH" , BASE_PATH."Public".DS) : PUBLIC_PATH;
!defined("IMAGES_PATH") ? define("IMAGES_PATH" , PUBLIC_PATH."images".DS) : IMAGES_PATH;
if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) AND isset($_SERVER['HTTP_HOST']))
{
 !defined("BASE_URL") ? define("BASE_URL" ,  $_SERVER['HTTP_X_FORWARDED_PROTO']."://".$_SERVER['HTTP_HOST']. preg_replace("/[a-z]+\.php/","",$_SERVER['SCRIPT_NAME'])) : BASE_URL;   
 !defined("PUBLIC_URL") ? define("PUBLIC_URL" , BASE_URL."Public/") : PUBLIC_URL;
!defined("IMAGES_URL") ? define("IMAGES_URL" , BASE_URL."Public/images/") : IMAGES_URL;
!defined("PROFILE_URL") ? define("PROFILE_URL" , BASE_URL."Public/images/profile/") : PROFILE_URL;
!defined("APP_CHAT_URL") ? define("APP_CHAT_URL" , BASE_URL."Public/images/app_chat/") : APP_CHAT_URL;
!defined("PUBLIC_URL") ? define("PUBLIC_URL" , BASE_URL."Public/") : PUBLIC_URL;
!defined("IMAGES_URL") ? define("IMAGES_URL" , BASE_URL."Public/images/") : IMAGES_URL;
!defined("PROFILE_URL") ? define("PROFILE_URL" , BASE_URL."Public/images/profile/") : PROFILE_URL;
!defined("CSS_URL") ? define("CSS_URL" , PUBLIC_URL."css/") : CSS_URL;
!defined("JS_URL") ? define("JS_URL" , PUBLIC_URL."js/") : JS_URL;
}

defined("DEFAULT_LANG") ? DEFAULT_LANG : define("DEFAULT_LANG" , "en");
defined("FIRSTKEY")  ? FIRSTKEY : define("FIRSTKEY" , "dLnHU+CYIyhpvXoRVcgym+XQGihBcuFfXGiaFQA9bSQ=");
defined("SECONDKEY")  ? SECONDKEY : define("SECONDKEY" , "sSbcYa1tapc1GwtF4IxDeSoyRxk4OguCIn573c3AY3YFnXYI5MopBqpH7Z//cvN3wlasidkiWvg2ZmZBlY7/ZA==");


require "Helpers/helper.php";

