<?php

include('title-clean.php');
include('edmunds.php');

function secrets($what) {
  $map = parse_ini_file('secrets.ini');
  if(isset($map[$what])) { 
    return $map[$what];
  }
}

//
// So most of edmunds apis require a style id
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
  // We can approach this from a number of angles.
  // Edmunds lists all the years as it turns out
  if(!isset($car_struct['year'])) {
    return false;
  }

  $makeListRaw = edmunds_getyear($car_struct['year']);
  if(!$makeListRaw) {
    throw new Error("Couln't find anything fdor year " . $car_struct['year']);
  }
  $makeList = json_decode($makeListRaw, true);
  // we look for the make
  $found = false;
  $allMakes = [];

  foreach($makeList['makes'] as $make) {
    if(strtolower($make['name']) == $car_struct['make']) {
      $found = true;
      break;
    }
    $allMakes[] = $make['name'];
  }
  if(!$found) {
    var_dump($car_struct);
    sort($allMakes);
    echo implode(" ", $allMakes) . "\n";
  }
  
  //var_dump($car_struct);
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

