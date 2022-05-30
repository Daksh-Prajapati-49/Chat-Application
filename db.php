<?php 
require 'Predis/Autoloader.php';
Predis\Autoloader::register();

$client = new Predis\Client();
// if($client -> ping()){
//     echo "you are successfully connected to redis server<br>";
// } else {
//     echo "connection to redis server failed<br>";
// }

?>
