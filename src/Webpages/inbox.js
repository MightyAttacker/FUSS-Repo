function showInbox() {
document.getElementById('outbox').style.display='none'
document.getElementById('inbox').style.display='block'
document.getElementById('sendMessage').style.display='none'

}

function showOutbox() {
document.getElementById('inbox').style.display='none'
document.getElementById('outbox').style.display='block'
document.getElementById('sendMessage').style.display='none'

}
function showMessage() {
document.getElementById('inbox').style.display='none'
document.getElementById('outbox').style.display='none'
document.getElementById('sendMessage').style.display='block'

}

function limitText(field, maxChar) {
    if (field.value.length > maxChar) {
        field.value = field.value.substring(0, maxChar);
    }else {
        document.getElementById("charNum").innerText = maxChar - field.value.length + " characters remaining";
    }
}      