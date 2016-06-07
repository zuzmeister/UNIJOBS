<?php
require("load.php");

//testvariablen
	//$ID = "262901";
	//$ID = "262447";

@$ID = $_GET["id"];
if(!$ID)
	$ID=262901;
$showPanelHeading=true;

if(substr($ID, -5)=='dwnld'){
	// We'll be outputting a html
	header('Content-Type: text/html');
	// It will be called downloaded.html
	header('Content-Disposition: attachment; filename="unijobs-'.$ID.'.html"');
	// The html source is in original.html
	$showPanelHeading=false;
}

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
    //die("Element not found");
    $inserat = $dom->getElementById('anzeige');
}

$kontakt = $dom->getElementById('legende');

if(!$kontakt)
{
    //die("Element not found");

}

///end

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
		<style type="text/css">
		.anzeige a{
			display: block;
		}
		h1{
			word-wrap: break-word;
		}
		img{
			max-width: 100%;
			height: auto;
		}
		</style>
	</head>
	<body>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					Better Unijobs (ID = 
					<?php echo $ID; ?>
					)
				</h3>
			</div>

			<?php
				if($showPanelHeading){
			?>

			<div class="panel-body">
			<ul class="pager">
				<li><a href="./<?php echo $ID-1; ?>">zurueck</a></li>
				<li><a href="./<?php echo $ID.'dwnld' ?>">DOWNLOAD</a></li>
				<li><a href="./<?php echo $ID+1; ?>">vor</a></li>
			</ul>
			</div>

			<?php
			}
			?>

		</div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8">

					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Anzeige</h3>
						</div>
						<div class="panel-body anzeige">
							<?php
								try{
									printAnzeige($inserat);
								}catch(Exception $e)
								{
									echo $e->getMessage();
								}
							?>
						</div>
					</div>	
				</div>
				<div class="col-md-4">
					<div class="panel panel-warning">
						<div class="panel-heading">
							<h3 class="panel-title">Kontakt</h3>
						</div>
						<div class="panel-body anzeige">
							<?php
								//echo strip_tags($kontakt->C14N(), '<p><a><strong><span><h1><h2><h3><ul><li>');
								try{
									printAnzeige($kontakt);
								}catch(Exception $e)
								{
									echo $e->getMessage();
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- jQuery -->
		<script src="//code.jquery.com/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</body>
</html>