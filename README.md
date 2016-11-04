# cl-xref

This is a greasemonkey script for cross-referencing car information to help people buy used cars who may not know that much about cars *points thumbs at self*.

## Background

A number of organizations track prices for cars and rate them. Here's a partial list.

 * Edmunds
 * Cars.com
 * Kelley Blue Book
 * Car and Driver
 * The Car Connection
 * US News Best Cars

If you normalize the point system (some are 10 based, some are 5 based), I've found there can be large disagreements in sources.

Using google's search resulsts (which give them) here's some normalized things. I just picked a number of cars based on what I found on craigslist and in a google search. This is not really anything scientific...

| car | edmunds | cars | kbb | 
| --- | --- | --- | --- | 
| 2015 Nissan Murano | 82 | 96 | 85 | 
| 2014 Nissan Versa | 72 | 76 | 72 | 
| 2014 Kia Forte | 82 | 92 | 81 |  
| 2013 Toyota Prius | 86 | 90 | 80 | 
| 2013 Scion xB | 98 | 78^1 | 64 |
| 2014 Mazda 2 | 80 | 78^2 | 69 |
| 2013 Hyundai Accent | 90 | 82 | 68 |
| 2015 Volkswagen Passat | 86 | 82 | 81 | 
| 2013 Kia Optima | 86 | 90 | 78 |

[1] The Car Connection
[2] US News Best Cars

Given this information, some cars appear to be "controversial" like the Scion xB or the Hyundai Accent.  This somewhat suggests that an 
average of Edmunds and KBB may be a decent approximation of the truth.

Surely if you don't know about cars and you said "I'm not getting anything below and 85" and you only used Edmunds, then the Scion xB would look like a sure win.
