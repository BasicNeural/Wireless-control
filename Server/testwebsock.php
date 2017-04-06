#!/usr/bin/env php
<?php
$conn = mysql_connect("localhost", "root", "Jeon151631");
    mysql_select_db("WebApp", $conn) or die("Error");

require_once('./websockets.php');

class echoServer extends WebSocketServer {
  //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
  
  protected function process ($user, $message) {
    $result = mysql_query("select * from Temp order by idx desc");
    $data = mysql_fetch_array($result);
    $this->send($user,$data[0]);
    $file = fopen("/home/pi/t.txt", "w");
    fwrite($file, $message);

    fclose($file);
  }
  
  protected function connected ($user) {
    
  }
  
  protected function closed ($user) {
    
  }
}

$echo = new echoServer("0.0.0.0","9000");

try {
  $echo->run();
}
catch (Exception $e) {
  $echo->stdout($e->getMessage());
}
