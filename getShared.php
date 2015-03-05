<?php
/**
 * Module getShared.php
 *
 * This project is a PHP console application which will scrape the BBC news website
 * and output a JSON string containg a list of most popular shared links.
 * 
 * Usage:  php getShared.php
 */

include ("include/clsLink.php");

// Create Shared link object
$clsLink = new SharedLink("");

$DOMDoc = new DOMDocument;
if (@$DOMDoc->loadhtmlfile('http://www.bbc.co.uk/news/')!==false) {
	
	// Locate the Most Populat section within the page
	$elMostPopular=$DOMDoc->getElementById('most-popular');
	$elSharedPanel=$elMostPopular->getElementsByTagName('div');
	$elSharedLinks=$elSharedPanel->item(0)->getElementsByTagName('a');
	
	// Loop through all Shared links, adding each one to the Shared link object
	for ($i = 0; $i < $elSharedLinks->length; $i++) {
		$clsLink->Add($elSharedLinks->item($i)->getAttribute('href'));
	}
	
	// Output the formatted JSON
	echo json_encode($clsLink,JSON_PRETTY_PRINT+JSON_UNESCAPED_SLASHES)."\n";
	
} else {
	echo "Failed to load the BBC homepage.  Check your internet connection and try again.\n";
}

?>
