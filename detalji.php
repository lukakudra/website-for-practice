<?php

    include('funkcije.php');
    $id = $_REQUEST['id'];

    $dom = new DOMDocument();
    $dom->load('podaci.xml');
    $xpath = new DOMXPath($dom);
    $query = '/zooloski-vrtovi/zooloski-vrt[contains(@id, "'. $id . '")]';
    //echo $query;
    //echo "</br>";
    $queryResult = $xpath->query($query);


    foreach($queryResult as $res) {
        if($id == $res->getAttribute('id')) {
            $parkingMjesto = $res->getElementsByTagName('parking-mjesto')->item(0)->nodeValue;
            $radiZimi = $res->getElementsByTagName('radi-zimi')->item(0)->nodeValue;
            $dozvoljenoHranjenje = $res->getElementsByTagName('dozvoljeno-hranjenje')->item(0)->nodeValue;
            $brojPosjetitelja = $res->getElementsByTagName('broj-posjetitelja')->item(0)->nodeValue;
            $brojVrsta = $res->getElementsByTagName('broj-vrsta')->item(0)->nodeValue;
            echo "<h2>Detalji:</h2>";
            echo "<b>Parking mjesto:</b> ";
            if(strlen($parkingMjesto) == 0) {
                echo "-";
            } else {
                echo $parkingMjesto;
            }
            echo "<br/><br/><b>Radi zimi:</b> ";
            if(strlen($radiZimi) == 0) {
                echo "-";
            } else {
                echo $radiZimi;
            }
            echo "<br/><br/><b>Dozvoljeno hranjenje:</b> ";
            if(strlen($dozvoljenoHranjenje) == 0) {
                echo "-";
            } else {
                echo $dozvoljenoHranjenje;
            }
            echo "<br/><br/><b>Broj posjetitelja:</b> ";
            if(strlen($brojPosjetitelja) == 0) {
                echo "-";
            } else {
                echo $brojPosjetitelja;
            }
            echo "<br/><br/><b>Broj vrsta:</b> ";
            if(strlen($brojVrsta) == 0) {
                echo "-";
            } else {
                echo $brojVrsta;
            }
            echo "<br/><br/><b>E-mail adresa:</b> ";
            foreach($res->getElementsByTagName('mail-adresa') as $mail) {
                if(strlen($mail->nodeValue) == 0) {
                    echo "-";
                } else {
                    echo $mail->nodeValue;
                }
                echo "<br/>";
            }
        }
    }
    sleep(1);
?>