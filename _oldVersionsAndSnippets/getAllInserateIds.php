<?php
require("../load.php"); //Funktionen um Daten von einer URL zu laden.

/** 
KonfigurationsVariablen
*/

$ID=262901;
$showPanelHeading=true;

//testvariablen
//$ID = "262901";
//$ID = "262447";


//lade Inserate-Verzeichnis
$inserateVerzeichnis = load("http://www.unijobs.at/_ajax/job_suche.php");


/**
$domInserate = new domDocument;
@$dom->loadHTML($inserateVerzeichnis);
$domInserate->preserveWhiteSpace = false;
 $inserat = $dom-> GETELEMENTBYCLASSNAME????????
*/

////////code taken from...
//// (http://www.binarytides.com/php-tutorial-parsing-html-with-domdocument/)
///begin

// a new dom object
$dom = new domDocument;  
// load the html into the object
@$dom->loadHTML($inserateVerzeichnis); 
// discard white space
$dom->preserveWhiteSpace = false;
//get element by id
/**
$inserat = $dom->getElementById('standard_inserat');
if(!$inserat)
{
    //die("Element not found");
    $inserat = $dom->getElementById('anzeige');
}

$kontakt = $dom->getElementById('legende');

if(!$kontakt)
{
    //die("Element not found");

}
*/
///end

/**
Function: printAnzeige
* 
*/
function printAnzeige($inserat)
{
	// zeige html-code der Anzeige, ohne div-tags und br-tag usw an...
	if(!$inserat)
		throw new Exception("Fehler: Keine Information", 1);
		
	$stripped = strip_tags($inserat->C14N(), '<img><style><p><a><strong><span><h1><h2><h3><ul><li>');
	// wandle mehrfach aufeinanderfolgende line-breaks in einen einzelnen br-tag um...
	$tempData = nl2br($stripped);
	$tempData = explode("<br />",$tempData);
	foreach ($tempData as $val) {
	   if(trim($val) != '')
	   {
	      echo $val."<br />";
	   }
	}
	//...ende
}

// filterElementsByClass
// suche nach CLASS x in allen TAGS y und löche diese 
function filterElementsByClass(&$dom, $tagName, $className) {
	$domNodeList = $dom->getElementsByTagname('li'); 
	$domElemsToRemove = array(); 
	foreach ( $domNodeList as $domElement ) { 
	  // ...do stuff with $domElement... 
		if ($domElement->getAttribute('class') != "listing") {
			$domElemsToRemove[] = $domElement; 
		}
	} 
	foreach( $domElemsToRemove as $domElement ){ 
	  $domElement->parentNode->removeChild($domElement); 
	}
}

// Ändere href in <a> tags, um auf eigene Plattform zu verweisen
function changeLinks(&$dom){
	$domNodeList = $dom->getElementsByTagname('a'); 
	foreach ( $domNodeList as $domElement ) { 
	  // ...do stuff with $domElement... 
		$domElement->setAttribute('onclick',' ');
		// man könnte auch strtok benutzen...
		$domElement->setAttribute('href','.'.strrchr($domElement->getAttribute('href'),'/'));
	} 
}

function getAllInserateIds(&$dom){
	$domNodeList = $dom->getElementsByTagname('a'); 
	foreach ( $domNodeList as $domElement ) { 
		echo substr(strrchr($domElement->getAttribute('href'),'/'), 1);
		echo "<br>";
	}
}

?>


<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>UNIJOBS API</title>
	</head>
	<body>
		<?php
			filterElementsByClass($dom,"li","listing");
			getAllInserateIds($dom);
		?>
	</body>
</html>