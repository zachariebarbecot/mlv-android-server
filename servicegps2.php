<?php

require 'class/mysql.php';
$db = new MySQL(true, "1096879", "localhost", "1096879", "sarakridane1992");


$response = array();

        $sql = "SELECT imei, latitude, longitude, MAX(date_gps) as date_gps, score"
            . " FROM gps_client GROUP BY imei";

			try {
			    // Begin our transaction
			    $db->TransactionBegin();
			    //Execute query/queries
			    $q = $db->Query($sql);

                $json = $db->GetJSON();
			    // Commit - this line never runs if there is an error
			    $db->TransactionEnd();

			    //$response['ok'] = $json;
				die('{"location": ' . $json . '}');
			} catch(Exception $e) {

			    // If an error occurs, rollback and show the error
			    $db->TransactionRollback();
			    $response['ok'] = $e->getMessage();
				die(json_encode($response));
			}
?>
