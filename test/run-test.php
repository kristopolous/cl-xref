#!/usr/bin/env php
<?php

include('../server/title-clean.php');

$titleList = file('title-list.txt');

function fail($what) {
  echo "!! $what";
}

function success($raw, $parsed) {
  echo "$raw " . implode(', ', array_values($parsed));
}

foreach($titleList as $title) {
  $clean = title_clean($title);
  if(!$clean) {
    fail($title);
  } else {
    success($title, $clean);
  }
}

