document.addEventListener("DOMContentLoaded", function(event) {
    var requestForm = document.forms.requestForm;
    requestForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var data = new FormData(requestForm);
        data.append('password', document.forms.authForm.password.value);
        httpPost(requestForm.action, data);
    });

    var authForm = document.forms.authForm;
    authForm.addEventListener('submit', function(event){
        event.preventDefault();
        var data = new FormData(authForm);
        httpPost(authForm.action, data);
    });

    var credentialsStored = httpGet("checkCredentialStorage.php");

    if (credentialsStored == "1")
    {
        document.getElementById("auth-new").style.display = "none";
    }
    else
    {
        document.getElementById("auth-reuse").style.display = "none";
    }

});

function httpGet(url)
{
    var request = new XMLHttpRequest();
    request.open("GET", url, false);
    request.send(null);
    return request.responseText;
}

function httpPost(url, postData) {
    var request = new XMLHttpRequest();
    request.responseType = 'json';
    request.open("POST", url);
    request.send(postData);
    request.onreadystatechange = responseHandler;
}

function responseHandler(httpState)
{
    if (httpState.currentTarget.readyState === 4)
    {
        var jsonResponse = httpState.currentTarget.response;

        if (jsonResponse.message != undefined)
        {
            document.getElementById("message").innerText = jsonResponse.message;
        }

        if (jsonResponse.response != undefined)
        {
            document.getElementById("response").innerText = JSON.stringify(jsonResponse.response);
        }
    }
}