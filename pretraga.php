<?php
    error_reporting (E_ALL);
    include_once('funkcije.php');

    $dom = new DOMDocument();
    $dom->load('podaci.xml');
    $xpath = new DOMXPath($dom);
    $query = getQuery();
    $queryResult = $xpath->query($query);
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Pretraživanje zooloških vrtova</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="dizajn.css">
        <script type="text/javascript" src="detalji.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
        integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
        crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>
    </head>

    <body>
        <div class="container">

            <header>
                <div class="slon">
                    <img src="elephant.png" alt="picture-of-elephant">
                </div>
                <h1>Zoološki vrtovi u svijetu</h1>
                <div class="slon-flipped">
                    <img src="elephant-flipped.png" alt="picture-of-elephant-mirrored">
                </div>
            </header>


            <div class="navigacija-index">
                <nav>
                    <ul>
                        <li class="pocetna">
                            <a href="index.html">Početna stranica</a>
                        </li>
                        <li>
                            <a href="obrazac.html">Pretraživanje</a>
                        </li>
                        <li>
                            <a href="podaci.xml">Podaci</a>
                        </li>
                        <li>
                            <a href="http://www.fer.unizg.hr/predmet/or">Otvoreno računarstvo</a>
                        </li>
                        <li>
                            <a target="_blank" href="http://www.fer.unizg.hr/">FER</a>
                        </li>
                        <li>
                            <a href="mailto:luka.kudra@gmail.com">Mail kontakt</a>
                        </li>

                    </ul>

                    <div id="detalji">
                    </div>

                </nav>
            </div>

            <article>

                <h2>Pretraživanje</h2>

                <div class = "pretrazivanje">
                    <table>
                        <tr>
                            <th>Ime</th>
                            <th>Cijena ulaznice [$]</th>
                            <th>Adresa</th>
                            <th>Slika</th>
                            <th>Akcija</th>
                        </tr>

                        <?php
                            foreach($queryResult as $elem) {
                        ?>
                        <tr onmouseover="promijeniBoju(this)" onmouseout="resetirajBoju(this)">


                            <?php
                                $streetLocal = $elem->getElementsByTagName('ulica')->item(0)->nodeValue;
                                $streets = $elem->getElementsByTagName('ulica');
                                foreach($streets as $newElem) {
                                    $pbrLocal = $newElem->getAttribute('kucni-broj');
                                }
                                $cityLocal = $elem->getElementsByTagName('mjesto')->item(0)->nodeValue;
                                $countryLocal = $elem->getElementsByTagName('drzava')->item(0)->nodeValue;
                                $adresaLocal = $streetLocal . " " . $pbrLocal . ", " .$cityLocal . ", " . $countryLocal;

                                $adresaFb = getAdress($elem->getAttribute('id'));
                                $adresa = "";
                                if(strlen($adresaFb) == 0) {
                                    $adresa = $adresaLocal;
                                } else {
                                    $adresa = $adresaFb;
                                }
                                $coord = getGeoCoord($adresa);
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_URL, $coord);
                                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($curl, CURLOPT_USERAGENT, 'Zooloski-vrtovi');
                                $curlResult = curl_exec($curl);
                                curl_close($curl);
                                if(strlen($curlResult) > 0) {
                                    $xml = simplexml_load_string($curlResult);
                                    $lat = $xml->place[0]['lat'];
                                    $long = $xml->place[0]['lon'];
                                    
                                } else {
                                    echo "Greska";
                                }

                                
                            ?>
                            <td>
                                <?php
                                    $ime = $elem->getElementsByTagName('ime')->item(0)->nodeValue;
                                ?>
                                <div class="hiperveze">
                                    <a target="_blank" href="<?php echo getWeb($elem->getAttribute('id'));?>"><?php echo $ime;?></a>
                                </div>
                            </td>
                            
                            <td>
                                <?php
                                    echo $elem->getElementsByTagName('cijena-ulaznice')->item(0)->nodeValue;
                                ?>
                            </td>

                            <td>
                                <?php
                                    echo $adresa;
                                ?>
                            </td>
                            <td>
                                <img src="<?php echo getPicture($elem->getAttribute('id'));?>" alt="slika" height="42" width="42"/>
                            </td>

                            <td>
                                <?php
                                    $url = "http://localhost/orlabos/lab5/detalji.php?id="."".$elem->getAttribute("id")."&show=simple";;
                                    $id = $elem->getAttribute("id");
                                    $web = getWeb($elem->getAttribute('id'));
                                ?>
                                <div class="detaljnaPretraga">
                                    <a href="#" onclick="prikaziDetalje('<?php echo $url ?>'); nacrtajKartu('<?php echo $lat ?>', '<?php echo $long ?>','<?php echo $ime ?>', '<?php echo $web ?>');">Detaljne informacije</a>
                                </div>
                            </td>
                            
                        </tr>
                        <?php
                            }
                        ?>

                    </table>
                        <div id="mapid">
                        </div>
                </div>

            </article>

            <footer>
                <p>Autor: Luka Kudra</p>
                <p>Fakultet elektrotehnike i računarstva, Zagreb</p>
            </footer>
        </div>
    </body>


</html>