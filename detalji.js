function promijeniBoju(mojRedTablice) {
    mojRedTablice.style.backgroundColor = "rgb(206, 206, 206)";
}

function resetirajBoju(mojRedTablice) {
    mojRedTablice.style.backgroundColor = "";
}

var zahtjev;
var karta;

function promijeniStranicu() {
    if (zahtjev.readyState = 4) {
        if (zahtjev.status == 200) {
            var odgovor = zahtjev.responseText;
            document.getElementById("detalji-podaci").innerHTML = odgovor;
        }
    } else {
        alert("Greška sa zahtjevom");
    }
}

function prikaziDetalje(url) {

    if (window.XMLHttpRequest) {
        zahtjev = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        zahtjev = new ActiveXObject("Microsoft.XMLHTTP");
    }

    document.getElementById('detalji').innerHTML = "<div id = 'detalji-podaci'></div>";
    document.getElementById("detalji-podaci").innerHTML = '<img src="Spinning_wheel_throbber.gif" alt="Molimo pricekajte" />';

    zahtjev.open("GET", url, true);
    zahtjev.send(null);
    zahtjev.onreadystatechange = promijeniStranicu;
}


function nacrtajKartu(lat, long, ime, web) {
    document.getElementById('mapid').innerHTML = '<img src="Spinning_wheel_throbber.gif" alt="Molimo pricekajte" />';
    document.getElementById('mapid').innerHTML = "<h2>Prikaz na karti:</h2><div id = 'karta' style='width: 95%; height: 250px;'></div>";

    var mymap = L.map('karta').setView([lat, long], 13);

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox.streets'
    }).addTo(mymap);

    L.marker([lat, long]).addTo(mymap)
        .bindPopup('Ime: ' + ime + '<br/>Širina: ' + lat + '<br/>Dužina: ' + long + '<br/><a target="_blank" href="' + web + '">Web lokacija</a>').openPopup();

}
