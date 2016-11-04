#!/usr/bin/env php
<?php

include('../server/title-clean.php');

$titleList = file('title-list.txt');

foreach($titleList as $title) {
  echo $title;
}

