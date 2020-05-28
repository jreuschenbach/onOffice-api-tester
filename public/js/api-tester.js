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
    })
});

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