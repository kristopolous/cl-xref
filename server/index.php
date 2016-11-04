<?php

function secrets($what) {
  $map = parse_ini_file('secrets.ini');
  if(isset($map[$what])) { 
    return $map[$what];
  }
}

function edmunds($ep, $query) {
  $key = secrets('edmunds');
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
  $key = secrets('kbb');
}

function price() {
  return edmunds('calculatetypicallyequippedusedtmv', [
    'zip' => $_REQUEST['zip'],
    'styleid' => 123
  ]);
}

function rating() {
}

function all() {
  return [
    'price' => price(),
    'rating' => rating()
  ];
}

$func = $_REQUEST['func'];
$query = $_REQUEST['query'];

if(in_array($func, ['all', 'price', 'rating'])) {
  echo json_encode($$func());
} 
