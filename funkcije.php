<?php
    
    function toUpper($string) {
		return	"translate(" . $string . ",  'abcdefghijklljmnnjopqrstuvwxyzšđčćž', 'ABCDEFGHIJKLLJMNNJOPQRSTUVWXYZŠĐČĆŽ')";
	}

    function getQuery() {
        $query = array();

        if (!empty($_REQUEST['ime'])) {
            $query[] = 'contains(' . toUpper('ime') . ', "' . mb_strtoupper($_REQUEST['ime'], "UTF-8") . '")';
        }
        
        if (!empty($_REQUEST['kontinent'])) {
            $queryKontinent = array();
            foreach ($_REQUEST['kontinent'] as $elem) {
                $queryKontinent[] = "@kontinent='" . $elem . "'";
            }
        }
        if (!empty($queryKontinent)) {
            $query[] = implode("or", $queryKontinent);
        }
        
        if (!empty($_REQUEST['drzava'])) {
            $query[] = 'contains(' . toUpper('adresa/drzava') . ', "' . mb_strtoupper($_REQUEST['drzava'], "UTF-8") . '")';
        }

        if (!empty($_REQUEST['mjesto'])) {
            $query[] = 'contains(' . toUpper('adresa/mjesto') . ', "' . mb_strtoupper($_REQUEST['mjesto'], "UTF-8") . '")';
        }

        if(!empty($_REQUEST['cijena'])) {
            $query[] = 'contains(cijena-ulaznice/@cijena, "' . $_REQUEST['cijena'] . '")';
        }


        if(!empty($_REQUEST['parking-mjesto'])) {
            $query[] = 'contains(parking-mjesto, "' . $_REQUEST['parking-mjesto'] . '")';
        }

        if(!empty($_REQUEST['dozvoljeno-hranjenje'])) {
            $query[] = 'contains(dozvoljeno-hranjenje, "' . $_REQUEST['dozvoljeno-hranjenje'] . '")';

        }

        if(!empty($_REQUEST['radi-zimi'])) {
            $query[] = 'contains(radi-zimi, "' . $_REQUEST['radi-zimi'] . '")';

        }

        if(!empty($_REQUEST['radi-ljeti'])) {
            $query[] = 'contains(radi-ljeti, "' . $_REQUEST['radi-ljeti'] . '")';

        }

        if(!empty($_REQUEST['dozvoljeno-djeci'])) {
            $query[] = 'contains(dozvoljeno-djeci, "' . $_REQUEST['dozvoljeno-djeci'] . '")';

        }

        if(!empty($_REQUEST['edukacija'])) {
            $query[] = 'contains(edukacija, "' . $_REQUEST['edukacija'] . '")';
        }

        if(!empty($_REQUEST['posjecenost'])) {
            $query[] = 'contains(broj-posjetitelja/@posjecenost, "' . $_REQUEST['posjecenost'] . '")';
        }

        if(!empty($_REQUEST['vrste'])) {
            $query[] = 'contains(broj-vrsta/@vrste, "' . $_REQUEST['vrste'] . '")';
        }
        


        $xpathQuery = implode(" and ", $query);

        if(!empty($xpathQuery)) {
		    return "/zooloski-vrtovi/zooloski-vrt[" . $xpathQuery . "]";

        } else {

            return "/zooloski-vrtovi/zooloski-vrt";
        }
    }
    
    function getAdress($arg) {
        $link = "http://161.53.67.82/fakebook/" . "" . $arg;
        $getJson = file_get_contents($link);
        if($getJson == FALSE) {
            $errorMessage = "Dogodila se pogreska prilikom dohvacanja trazenog resursa";
            echo $errorMessage;
            
        } else {
            $decode = json_decode($getJson);
            if (isset($decode)) {
                return $decode->details->location->street . ", " . $decode->details->location->city . ", " . $decode->details->location->country;
            } else {
                echo "Dogodila se pogreska prilikom dekodiranja";
            }
        }
    }

    function getPicture($arg) {
        $link = "http://161.53.67.82/fakebook/" . "" . $arg;
        $getJson = file_get_contents($link);
        if($getJson == FALSE) {
            $errorMessage = "Dogodila se pogreska prilikom dohvacanja trazenog resursa";
            echo $errorMessage;
        } else {
            $decode = json_decode($getJson);
            if (isset($decode)) {
                return $decode->details->picture;
            } else {
                echo "Dogodila se pogreska prilikom dekodiranja";
            }
        }
    }

    function getWeb($arg) {
        $link = "http://161.53.67.82/fakebook/" . "" . $arg;
        $getJson = file_get_contents($link);
        if($getJson == FALSE) {
            $errorMessage = "Dogodila se pogreska prilikom dohvacanja trazenog resursa";
            echo $errorMessage;
        } else {
            $decode = json_decode($getJson);
            if (isset($decode)) {
                return $decode->details->website;
            } else {
                echo "Dogodila se pogreska prilikom dekodiranja";
            }
        }
    }

    function getGeoCoord($arg) {
        $link = "https://nominatim.openstreetmap.org/search.php?q=";
        $makeLink = urlencode($arg);
        $query = $link.$makeLink."&format=xml";
        return $query;
    }


?>