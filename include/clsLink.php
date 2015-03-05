<?php

/**
 * Class Link
 *
 * Holds attributes for each shared link
 */
class Link {
	public $title;
	public $href;
	public $size;
	public $most_used_word;
}


/**
 * Class SharedLink
 *
 * Holds a collection of Links and functions to extract link attributes
 */
class SharedLink {
	
	public $results = array();

	//Condtructor
	function SharedLink() {
	}
	
	/**
	 * Function Add
	 *
	 * Add supplied HREF to the list of shared results if the page is found
	 */
	function Add($href) {
		$clsLink = new Link();
		$clsLink->href=$href;
		// If the Shared link loads ok then add it to the list to be returned
		if ($this->getLinkDetails($clsLink)) {
			array_push($this->results,$clsLink);
		}
	}
		
	/**
	 * Function getLinkDetails
	 *
	 * Retrieve HTML for the supplied HREF, read H1 tag, calculate page size
	 * and call function to calculate most used word
	 */
	private function getLinkDetails($clsLink) {
		
		$sPage=@file_get_contents($clsLink->href);
		if ($sPage!==false) {
		
			// Get the main contend div from the page
			$DOMDoc = new DOMDocument;
			@$DOMDoc->loadHTML($sPage);
			$elPageBody=$DOMDoc->getElementById('main-content');
			
			// Read text from the article
			$elStoryBody=$elPageBody->getElementsByTagName('div')->item(1);
			$elParagraphs=$elStoryBody->getElementsByTagName('p');
			$sArticleText="";
			for ($i = 0; $i < $elParagraphs->length; $i++) {
				//echo $elParagraphs->item($i)->nodeValue . "\n";
				$sArticleText.=$elParagraphs->item($i)->nodeValue;
			}
			
			// Get the page / article title
			$h1Tags=$DOMDoc->getElementsByTagName('h1');
			$clsLink->title=$h1Tags->item(0)->nodeValue;
			
			// Calculate the page size
			$clsLink->size=round(strlen($sPage)/1024,1)."Kb";
			
			// Calculate the most used word
			$clsLink->most_used_word=$this->getMostCommonWord($sArticleText);
			
			return true;
			
		} else {
			// Failed to load HTML for Shared link
			return false;
		}
	}
	
	/**
	 * Function getMostCommonWord
	 *
	 * Calculate the most frequently used word for a given string
	 */
	private function getMostCommonWord($sPage) {
		//$aStopList=array("the","a","is","and","i");
		$aStopList=array("the","and","this","was","are","for","they","had");
		
		// Build an array of words on the page
		$aWords=array();
		$items=explode(" ",strtolower($sPage));
		for ($i=0;$i<count($items);$i++) {
			// Only add strings without special characters and which are not in the stop list
			if(preg_match("/^[a-zA-Z]+$/", $items[$i])) {
				if (array_search($items[$i], $aStopList)===false && strlen($items[$i])>2 ) {
					array_push($aWords,$items[$i]);
				}
			}
		}
		
		// Count occurrences of words and return the most frequent
		$aWordCounts=array_count_values($aWords);
		arsort($aWordCounts);
		return key($aWordCounts);
	}	
}

?>