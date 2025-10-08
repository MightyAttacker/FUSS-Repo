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