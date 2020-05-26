document.addEventListener("DOMContentLoaded", function(event) {
    console.log(httpGet('php/ooapitest.php'));
});

function httpGet(theUrl)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
    xmlHttp.send( null );
    return xmlHttp.responseText;
}