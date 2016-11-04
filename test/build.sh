#!/bin/bash


[ -e rawhtml ] && rm rawhtml

for i in `seq 0 100 1000`; do
  curl 'http://losangeles.craigslist.org/search/cto?s='$i'&max_auto_miles=170000&min_auto_year=2007&min_price=4000&postal=90034&search_distance=30' >> rawhtml
done 

car rawhtml | grep -Po '(?<=result-title hdrlnk">)([^<]*)' >> title-list.txt

cat title-list.txt | sort | uniq > tmp
mv tmp title-list.txt
