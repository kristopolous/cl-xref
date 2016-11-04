<?php

function edmunds($ep, $query) {
  $url = implode('', [
    'https://api.edmunds.com/v1/api/tmv/tmvservice/',
    $ep, '?',
    http_build_query(array_merge($query, [
      'fmt' => 'json',
      'api_key' => $key
    ])
  ]);
  return file_get_contents($url);
}

function kbb($ep, $query) {
}

function price() {
  return edmunds('calculatetypicallyequippedusedtmv', [
    'zip' => $_REQUEST['zip'],
    'styleid' => 123
  ]);
}

function rating() {
}

$func = $_REQUEST['func'];
$query = $_REQUEST['query'];
$zip = $_REQUEST['zip'];

if(in_array($func, ['price', 'rating'])) {
  echo json_encode($$func());
} 
