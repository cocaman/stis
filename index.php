<?php

@header("Content-type: text/xml; charset=\utf-8\"",true);
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
echo "<sbbprosurf station=\"". $pbp ."\">\n";

include_once("htmlsql/snoopy.class.php");
include_once("htmlsql/htmlsql.class.php");
include_once("functions.inc.php");

$wsql = new htmlsql();
$tsql = new htmlsql();

if(isset($_GET['pbp'])) {
	$pbp = strtoupper($_GET['pbp']);
} else {
	$pbp = "ZUE";
}


//if (!$wsql->connect('url', 'http://projects.cocaman.net/sbb-twitter/demo.html')){
if (!$wsql->connect('url', 'http://prosurf.sbb.ch/pros/inter/prosurfservlet?TRANSACTION=004&LANGUAGE=d&PBP='. $pbp .'&DIRECTION=2')){
	//print 'Error while connecting: ' . $wsql->error;
	exit;
}

if (!$wsql->query('SELECT * FROM td')){
	//print "Query error: " . $wsql->error;
	exit;
}

$rowcounter = 1;

$lines = array();

foreach($wsql->fetch_array() as $row){

	if(count($row) == 3) {

		if($rowcounter > 10) {
			array_push($lines, $row);
		}
	}
	$rowcounter++;
}

$counter = 0;
while($counter < count($lines)) {

	if(($counter+4) == count($lines)+1) {
		//echo "<help>". html_escape($lines[$counter++]['text']) ."</help>\n";
		//echo "<home>". html_escape($lines[$counter++]['text']) ."</home>\n";
		$counter++;
		$counter++;
		echo "\t<lastupdate>". str_replace("\n", "", html_escape($lines[$counter++]['text'])) ."</lastupdate>\n";

	} else {
		// fill variables to play with later!
		$_departure = 		$lines[$counter++]['text'];
		$_type = 			$lines[$counter++]['text'];
		$_number = 			getTrainNumber($lines[$counter++]['text']);
		$_terminus = 		$lines[$counter++]['text'];
		$_predicted = 		replace_space($lines[$counter++]['text']);
		$_notes = 			$lines[$counter++]['text'];

		if(stristr($_type, "61_ab.gif")) {
			$ztype = "S-Bahn";
		} elseif (stristr($_type, "40_ab.gif")) {
			$ztype = "Eurocity";
		} elseif (stristr($_type, "41_ab.gif")) {
			$ztype = "InterCityExpress";
		} elseif (stristr($_type, "42_ab.gif")) {
			$ztype = "TGV";
		} elseif (stristr($_type, "43_ab.gif")) {
			$ztype = "Cisalpino";
		} elseif (stristr($_type, "53_ab.gif")) {
			$ztype = "Regional Express";
		} elseif (stristr($_type, "50_ab.gif")) {
			$ztype = "InterCity";
		} elseif (stristr($_type, "51_ab.gif")) {
			$ztype = "InterRegio";
		} elseif (stristr($_type, "60_ab.gif")) {
			$ztype = "Regional";
		} else {
			$ztype = "unknown";
		}

		$status = "";
		if($_notes != "&nbsp;" && $_notes != "keine Angaben") {
			$status .= "Der Zug nach ". $_terminus ." (".$ztype."), Abfahrt um ". $_departure ." meldet: " . $_notes . "\n";
		}

		if(strtotime($_predicted) - strtotime($_departure) > 180) {
			//$status .= "Der Zug nach " . $_terminus . " hat mehr als 3 Minuten Verspätung!";
		}

		$timeDept = strtotime($_departure);

		if($timeDept < date("U")) {
			$status = "";
		}

		if($status != "") {
			$status = str_replace("&nbsp;", " ", $status);
			$status = str_replace("&uuml;", "ü", $status);
			$status = str_replace("&auml;", "ä", $status);
			$status = str_replace("&ouml;", "ö", $status);
			$status = str_replace("&egrave;", "é", $status);
			postToTwitter($pbp,$status);
			//echo "status: " . $status;
		}

		echo "\t<report>\n";
		echo "\t\t<departure>". html_escape($_departure) ."</departure>\n";
		echo "\t\t<type>". $ztype . "</type>\n";
		echo "\t\t<number>". html_escape($_number) ."</number>\n";
		echo "\t\t<terminus>". str_replace("&amp;amp;nbsp;", "", ($_terminus)) ."</terminus>\n";
		echo "\t\t<predicted>". html_escape($_predicted) ."</predicted>\n";

		echo "\t\t<notes>". $_notes ."</notes>\n";
		echo "\t</report>\n";
	}
}

echo "</sbbprosurf>\n";
?>