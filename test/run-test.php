#!/usr/bin/env php
<?php

include('../server/title-clean.php');

$titleList = file('title-list.txt');

function fail($what) {
  echo "!! $what";
}

function success($raw, $parsed) {
  echo implode(', ', array_values($parsed)) . " || " . $raw;
}

$cnt = 0;
$fail = 0;
foreach($titleList as $title) {
  $clean = title_clean($title);
  if(!$clean || !$clean['make']) {
    $fail ++;
    fail($title);
  } else {
    //success($title, $clean);
  }
  $cnt++;
}

echo round(100 - (100 * $fail/$cnt)) . "% pass";
