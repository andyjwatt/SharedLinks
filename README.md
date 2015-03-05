
## Overview

This project is a PHP console application which will scrape the BBC news website and output a JSON string containg a list of most popular shared links.


## Requires 

PHP 5.4+
PHP5-JSON - sudo apt-get install php5-json 


## Example

{
    "results": [
        {
            "title": "'Fairy control' to halt tiny doors in Somerset woods",
            "href": "http://www.bbc.co.uk/news/uk-england-somerset-30687171",
            "size": "120.7Kb",
            "most_used_word": "fairy"
        },
        {
            "title": "Weasel photographed riding on a woodpecker's back  ",
            "href": "http://www.bbc.co.uk/news/uk-31711446",
            "size": "108.2Kb",
            "most_used_word": "woodpecker"
        },


## Running

To run this application from the console:

* Navgate to the installation folder

* php getShared.php


