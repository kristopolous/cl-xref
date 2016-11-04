#!/bin/bash

[ -e rawhtml ] && rm rawhtml

grab() {
  city=$1
  zip=$2
  echo -n "Grabbing $city $zip..."
  for i in `seq 0 100 2000`; do
    echo -n $i...
    curl -s 'http://'$city'.craigslist.org/search/cto?s='$i'&max_auto_miles=170000&min_auto_year=2000&min_price=4000&postal='$zip'&search_distance=40' >> rawhtml
  done 
  echo ''
}

grab losangeles 90034
grab sacramento 94203
grab seattle 98101

cat rawhtml | grep -Po '(?<=result-title hdrlnk">)([^<]*)' >> title-list.txt

cat title-list.txt | sort | uniq > tmp
mv tmp title-list.txt
