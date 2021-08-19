<?php
use System\Application;

$app = Application::getinstance();

$app->route->addRoute("/","Home");
$app->route->addRoute("/getAllUser","Home@getAllUser");
$app->route->addRoute("/search","Home@search");
$app->route->addRoute("/end","Home@end");
$app->route->addRoute("/signup","Signup");
$app->route->addRoute("/signup/submit","Signup@submit");
$app->route->addRoute("/login","Login");
$app->route->addRoute("/login/submit","Login@submit");
$app->route->addRoute("/logout","Logout");
$app->route->addRoute("/userchat/:id","UserChat");
$app->route->addRoute("/userchat/keepactive/:id","UserChat@keepactive");
$app->route->addRoute("/userchat/keepmessageactive/:id","UserChat@keepmessageactive");
$app->route->addRoute("/userchat/submit/:id","UserChat@submit");
$app->route->addRoute("/accessdenied","AccessDenied");
$app->route->addRoute("/notfound","NotFound");
$app->addInContainer("layout",function($app)
  {
    return  $app->load->controller("layout");
  }
);
$app->route->callFirst(function($app)
{
  return  $app->load->controller("access")->index();
});













