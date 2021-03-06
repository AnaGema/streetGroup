function uploadCSV() {
    let formData = new FormData();
    let file = document.getElementById('csvFile').files[0];
    formData.append('file', file);

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == XMLHttpRequest.DONE) {
            console.log(xhttp.responseText);
        }
    }
    xhttp.open('POST', 'handler/handler.php', true);
    xhttp.send(formData);
}