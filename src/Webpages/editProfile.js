function limitText(field, maxChar) {
    if (field.value.length > maxChar) {
        field.value = field.value.substring(0, maxChar);
    }else {
        document.getElementById("charNum").innerText = maxChar - field.value.length + " characters remaining";
    }
}   