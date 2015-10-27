<?php //echo exec('whoami'); 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors','On');
phpinfo();
ini_set('session.gc_maxlifetime',86400);
echo 'ini:'.ini_get('session.gc_maxlifetime');
?>
