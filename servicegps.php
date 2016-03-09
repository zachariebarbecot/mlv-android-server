<?php

require 'class/mysql.php';
$db = new MySQL(true, "database", "server", "login", "password");


$response = array();

	if(!empty($_REQUEST)){

		$num 		= $_POST['numero'];
		$imei 		= $_POST['imei'];
		$bat 		= $_POST['batteryPct'];
		$lat 		= $_POST['latitude'];
		$lng 		= $_POST['longitude'];
		$date 		= date('d-m-Y H:i:s');
		$dateGPS 	= date($_POST['dateGps']);
		$dateCell 	= date($_POST['dateCell']);
		$score 		= $_POST['score'];

		$sql = "INSERT INTO gps_client (numero, imei, battery, latitude,"
			. " longitude, date_creation, date_gps, date_cell, score)"
			. " VALUES ('" . $num . "', '" . $imei . "', " .$bat . ", " .$lat
			. ", " .$lng . ", STR_TO_DATE('" .$date . "', '%d-%m-%Y %H:%i:%s'),"
			. " STR_TO_DATE('" .$dateGPS . "', '%d-%m-%Y %H:%i:%s'),"
			. " STR_TO_DATE('" . $dateCell . "', '%d-%m-%Y %H:%i:%s'), "
			. $score . ")";

			try {
			    // Begin our transaction
			    $db->TransactionBegin();
			    //Execute query/queries
			    $db->Query($sql);
			    // Commit - this line never runs if there is an error
			    $db->TransactionEnd();

			    $response['ok'] = 'Verifier la table de gps_client ' . $sql;
				die(json_encode($response));
			} catch(Exception $e) {

			    // If an error occurs, rollback and show the error
			    $db->TransactionRollback();
			    $response['ok'] = $e->getMessage();
				die(json_encode($response));
			}
	}
?>
