<?php

require 'class/mysql.php';
$db = new MySQL(true, "database", "hostname", "login", "password");


$response = array();

        $sql = "SELECT imei, latitude, longitude, date_gps, score "
            . " FROM gps_client gc WHERE gc.score = (SELECT MAX(score)"
            . " FROM gps_client gcl WHERE gcl.imei = gc.imei) GROUP BY imei";

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
