<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" type="text/css" href="https://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css">
        <style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0px; padding: 0px }
            #global { height: 100%; width:100%; }
            #sara_map { height: 100%; width:100%; }
            .labels {
                    background-color: #fff;
                    border: 1px solid #1cba1c;
                    box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);
                    color: #333;
                    font-size: 11px;
                    left: 35px;
                    line-height: normal;
                    max-width: 190px;
                    min-width: 110px;
                    padding: 5px;
                    position: absolute;
                    right: 7px;
                    text-align: left;
                    top: 45px;
            }
        </style>
    </head>
    <body>
        <div id="global">
            <div id="map">
                <?php

                require 'class/mysql.php';
                $db = new MySQL(true, "database", "server", "login", "password");
                if ($db->Error()) $db->Kill();
                // Execute our query
                if (! $db->Query("SELECT tbl.* FROM (SELECT * FROM gps_client ORDER BY date_gps DESC) as tbl GROUP BY imei")) $db->Kill();



                require('class/GoogleMapAPI.php');
                $gmap = new GoogleMapAPI();
                $gmap->setDivId('sara_map');
                $gmap->setCenter('paris France');
                $gmap->setClusterer(true);
                $gmap->setZoom(5);
                $gmap->setEnableWindowZoom(true);
                $gmap->setEnableAutomaticCenterZoom(true);
                $gmap->setLang('en');

                $coordtab = array();

                // Loop through the records using a counter and display the values
                for ($index = 0; $index < $db->RowCount(); $index++) {
                    $row = $db->Row($index);
                    $level = ($row->battery > 0 && $row->battery <= 0.20)?"fa-battery-0":(($row->battery > 0.20 && $row->battery <= 0.40)?"fa-battery-1":(($row->battery > 0.40 && $row->battery <= 0.60)?"fa-battery-2":(($row->battery > 0.60 && $row->battery <= 0.80)?"fa-battery-3":"fa-battery-4")));


                    $html  = '<center><strong>Phone N° '.$row->imei.'</strong></center>';
                    $html .= '<br>';
                    $html .= "<i class='fa $level fa-pull-right'></i>";
                    $html .= "<img src='images/mobile.png'>";
                    $html .= '&nbsp;&nbsp;';
                    $html .= str_replace("null<br />", "", $row->numero);
                    $html .= '<br>';
                    $html .= "<i class='fa fa-bar-chart'>&nbsp;&nbsp; Score : &nbsp;&nbsp;".$row->score." points</i>";
                    $html .= '<br>';
                    $html .= $row->date_gps;
                    $coordtab []= array($row->latitude,
                                        $row->longitude,
                                        $row->imei,
                                        $html);
                }

                $gmap->addArrayMarkerByCoords($coordtab,'cat1','images/videogames.png');

                $gmap->generate();
                echo $gmap->getGoogleMap();
                ?>
            </div>
        </div>
    </body>
</html>
