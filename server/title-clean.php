<?php

date_default_timezone_set('UTC');
$db = new SQLite3(dirname(__FILE__) . "/../db/main.db");

$mapper = [
  'vw' => 'volkswagen',
  'gm' => 'gmc',
  'chevy' => 'chevrolet',
  'mercedes' => 'mercedes-benz',
  'mbz' => 'mercedes-benz'
];
$guessMap = [];


function guess_model($what) {
  global $db, $mapper, $guessMap;

  $partList = explode(' ', strtolower($what));
  $make = false;
  $model = false;
  $extra = false;
  foreach($partList as $part) {
    if($make) {
      if(!$model) {
        $model = $part;
        continue;
      } 

      if(!isset($guessMap["$make $model"])) {
        $guessMap["$make $model"] = 0;
      }
      $guessMap["$make $model"]++;

      $extra = $part;
      $key = trim("$make $model $extra");
      if(!isset($guessMap[$key])) {
        $guessMap[$key] = 0;
      }
      $guessMap[$key]++;

      return;
    }

    if(isset($mapper[$part])) {
      $part = $mapper[$part];
    }
    $query = "select count(*) from VehicleModelYear where make like '" . $db->escapeString($part) . "'";
    $res = $db->query($query)->fetchArray();
    // ah we found something
    if($res[0] > 0) {
      $make = $part;
    }
  } 
}
function get_model($what, &$obj) {
  global $db;

  $partList = array_filter(explode(' ', strtolower($what)));
  $prev = false;
  foreach($partList as $part) {
    // this seems to be dangerous to do to the whole string unfortunately.
    $part = preg_replace('/\-/', '', $part);

    if(isset($mapper[$part])) {
      $part = $mapper[$part];
    }
    //echo "($part) " ;
    $query = "select distinct make, model from VehicleModelYear where model like '" . $db->escapeString($part) . "'";
    $res = $db->query($query)->fetchArray();
    if($res) {
      $obj['make'] = $res['make'];
      $obj['model'] = $res['model'];
      return;
    }
    if($prev) {
      $tuple = "$prev $part";
      $query = "select distinct make, model from VehicleModelYear where model like '" . $db->escapeString($tuple) . "'";
      $res = $db->query($query)->fetchArray();
      if($res) {
        $obj['make'] = $res['make'];
        $obj['model'] = $res['model'];
        return;
      }
    }
    $prev = $part;
  } 
  $obj['make'] = null;
  echo implode(' ', $partList);
  guess_model($what);
}

function get_make($what) {
  global $db, $mapper;

  $partList = explode(' ', strtolower($what));
  foreach($partList as $part) {
    if(isset($mapper[$part])) {
      $part = $mapper[$part];
    }
    $query = "select count(*) from VehicleModelYear where make like '" . $db->escapeString($part) . "'";
    $res = $db->query($query)->fetchArray();
    if($res[0] > 0) {
      //echo "($part)" . $res->numColumns() . "$query\n";
      return $part;
    }
  } 
}

function get_year(&$what, &$obj) {
  // The *best* case is when we have 20\d\d
  if(
    preg_match('/^\'?(\d\d)\'? /', $what, $matches, PREG_OFFSET_CAPTURE) ||
    preg_match('/(20|19)\d\d/', $what, $matches, PREG_OFFSET_CAPTURE)) {
    $off = $matches[0][1];

    $what = substr($what, 0, $off) . substr($what, $off + strlen($matches[0][0]));
    $obj['year'] = $matches[0];
    return;
  }
  // this is the format
  // 09 or
  // '09
  if(
    preg_match('/ \'?(0\d)\'?/', $what, $matches)
  ) {
    $attempt = intval($matches[1]);

    $prefix = '20';
    if($attempt > 50) {
      $prefix = '19';
    }

    $obj['year'] = $prefix . $matches[1];
  }
}

function title_clean($clean) {
  // There's things like the Fancy Car 3-4 from manufacturers ... don't ask me.
  // Ex. Saab 9-3
  //$clean = preg_replace('/(\d+)-(\d+)/', '$1$2', $clean);
  // our modest goal is a year make and model.
  $clean = preg_replace('/[^\w\s\-]/', ' ', $clean);
  $clean = preg_replace('/\s+/', ' ', $clean);

  $ret = [];
  get_year($clean, $ret);
  $clean = preg_replace('/^\s+/', '', $clean);
  // I want to do truncation only after the year was guessed.
  $clean = preg_replace('/\-(\d)/', '$1', $clean);
  get_model($clean, $ret);
  return $ret;
}

function show_guesses() {
  global $guessMap;
  foreach($guessMap as $key => $value) {
    if($value < 3) {
      unset($guessMap[$key]);
    }
  }
  echo json_encode($guessMap, JSON_PRETTY_PRINT);
}
