<?php
require("../load.php");


$ID = "262901";


$contents = load("http://www.unijobs.at/_ajax/jobs_getjob.php?anzid=$ID");

////////code taken from...
//// (http://www.binarytides.com/php-tutorial-parsing-html-with-domdocument/)
///begin

// a new dom object
$dom = new domDocument;  
// load the html into the object
@$dom->loadHTML($contents); 
// discard white space
$dom->preserveWhiteSpace = false;
//get element by id
$inserat = $dom->getElementById('standard_inserat');
if(!$inserat)
{
    die("Element not found");
}

$kontakt = $dom->getElementById('legende');

if(!$kontakt)
{
    die("Element not found");
}

///end

function printAnzeige($inserat)
{
	// zeige html-code der Anzeige, ohne div-tags und br-tag usw an...
						$stripped = strip_tags($inserat->C14N(), '<p><a><strong><span><h1><h2><h3>');
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

?>


<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>UNIJOBS API</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Better Unijobs</h3>
			</div>
			<div class="panel-body">
				<span>UNIJOBS ID = 
			<?php
			 echo $ID;
			?></span>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8">
					<h1>
						Anzeige
					</h1>
					<?php
						printAnzeige($inserat);
					?>		
				</div>
				<div class="col-md-4">
					<h2>
						Kontakt
					</h2>
					<?php
						echo strip_tags($kontakt->C14N(), '<p><a><strong><span><h1><h2><h3>');
					?>
				</div>
			</div>
		</div>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>