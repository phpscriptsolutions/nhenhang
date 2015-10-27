<?php
function google_api_php_client_autoload($className)
{
  $classPath = explode('_', $className);
  if ($classPath[0] != 'Google') {
    return;
  }
  // Drop 'Google', and maximum class file path depth in this project is 3.
  $classPath = array_slice($classPath, 1, 2);
  $filePath = dirname(__FILE__) . '/' . implode('/', $classPath) . '.php';
  if (file_exists($filePath)) {
    require_once $filePath;
  }
}

spl_autoload_register('google_api_php_client_autoload');
/*require_once 'Client.php';
require_once 'Config.php';
require_once 'Model.php';
require_once 'Service.php';
require_once 'Collection.php';
require_once 'Service/Resource.php';
require_once 'Service/Urlshortener.php';
require_once 'Service/Plus.php';
require_once 'Service/Oauth2.php';*/
