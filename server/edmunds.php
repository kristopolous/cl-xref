<?php

$cache_dir = dirname(dirname(__FILE__)) . '/cache/';

function edmunds($ep, $query) {
  $key = secrets('edmunds');
  global $cache_dir;

  if(in_array($ep, ['makes'])) {
    $base = 'http://api.edmunds.com/api/vehicle/v2/';
  } else {
    $base = 'https://api.edmunds.com/v1/api/tmv/tmvservice/';
  }

  $url = implode('', [
    $base,
    $ep, '?',
    http_build_query(array_merge($query, [
      'fmt' => 'json',
      'api_key' => $key
    ]))
  ]);

  $cache_name = $cache_dir . md5($url);
  if(!file_exists($cache_name)) {
    file_put_contents($cache_name, file_get_contents($url));
  }
  return file_get_contents($cache_name);
}


function edmunds_getyear($year) {
  return edmunds('makes', ['year' => $year]);
}
