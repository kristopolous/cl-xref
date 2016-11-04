<?php

$makelist = array_map(function($what) { return trim($what); }, file(dirname(__FILE__) . '/make.txt'));

$mapper = [
  'vw' => 'volkswagen',
  'gm' => 'gmc',
  'chevy' => 'chevrolet',
  'mercedes-benz' => 'mercedes'
];

function get_make($what) {
  global $makelist, $mapper;

  $partList = explode(' ', strtolower($what));
  foreach($partList as $part) {
    if(isset($mapper[$part])) {
      $part = $mapper[$part];
    }
    if(array_search($part, $makelist)) {
      return $part;
    }
  }
}

function get_year($what) {
  // The *best* case is when we have 20\d\d
  if(preg_match('/(20|19)\d\d/', $what, $matches)) {
    return $matches[0];
  }
  // this is the format
  // 09 or
  // '09
  if(
    preg_match('/^\'?(\d\d)\'? /', $what, $matches) ||
    preg_match('/ \'?(0\d)\'?/', $what, $matches)
  ) {
    $attempt = intval($matches[1]);

    $prefix = '20';
    if($attempt > 50) {
      $prefix = '19';
    }

    return $prefix . $matches[1];
  }
}

function title_clean($dirty) {
  // our modest goal is a year make and model.
  $clean = preg_replace('/[^\w\s]/', ' ', $dirty);
  $clean = preg_replace('/\s+/', ' ', $clean);

  return [
    'year' => get_year($clean),
    'make' => get_make($clean)
  ];
}

