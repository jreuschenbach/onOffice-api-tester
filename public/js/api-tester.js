document.addEventListener("DOMContentLoaded", function(event) {
    var requestForm = document.forms.requestForm;
    requestForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var data = new FormData(requestForm);
        disableSendButton();
        appendMessage("sending request to onOffice API...");
        httpPost(requestForm.action, data);
    });
});

function httpPost(url, postData) {
    var request = new XMLHttpRequest();
    request.responseType = 'json';
    request.open("POST", url);
    request.send(postData);
    request.onreadystatechange = responseHandler;
}

function appendMessage(message)
{
    var messageBox = document.getElementById("message");
    messageBox.innerText = messageBox.innerText.concat("\n" + message);
    messageBox.scrollTop = messageBox.scrollHeight;
}

function responseHandler(httpState)
{
    if (httpState.currentTarget.readyState === 4)
    {
        var jsonResponse = httpState.currentTarget.response;

        if (jsonResponse.message != undefined)
        {
            appendMessage(jsonResponse.message);
        }

        if (jsonResponse.response != undefined)
        {
            document.getElementById("response").innerText = JSON.stringify(jsonResponse.response, null, 2);
        }

        enableSendButton();
    }
}

function disableSendButton()
{
    document.getElementById("sendRequest").disabled = "disabled";
}

function enableSendButton()
{
    document.getElementById("sendRequest").disabled = null;
}