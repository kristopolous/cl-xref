<?php

include('lib.php');

$func = $_REQUEST['func'];
$query = $_REQUEST['query'];

if(in_array($func, ['all', 'price', 'rating'])) {
  echo json_encode($$func());
} 
