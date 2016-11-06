<?php

include('title-clean.php');

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
    ]))
  ]);
  return file_get_contents($url);
}

//
// So most of endmunds apis require a style id
// that you can get with this query...
//
// I could make this a php class but they're a
// pain ... so just make sure that there's
//
//  year, make, model
//
// keys and values here.
//
function edmunds_getstyle($car_struct) {
  var_dump($car_struct);
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

