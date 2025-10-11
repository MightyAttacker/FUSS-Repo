document.addEventListener('DOMContentLoaded', function() {
    const activeSection = localStorage.getItem('activeSection') || 'academicEdit';
    document.getElementById("academicEdit").style.display = "none";
    document.getElementById("otherEdit").style.display = "none";
    document.getElementById("requestedEdit").style.display = "none";
    document.getElementById(activeSection).style.display = "flex";
});

function limitText(field, maxChar) {
    if (field.value.length > maxChar) {
        field.value = field.value.substring(0, maxChar);
    }else {
        document.getElementById("charNum").innerText = maxChar - field.value.length + " characters remaining";
    }
} 

function showAcademic() {
    document.getElementById("academicEdit").style.display = "flex";
    document.getElementById("otherEdit").style.display = "none";
    document.getElementById("requestedEdit").style.display = "none";
    localStorage.setItem('activeSection', 'academicEdit');
}
function showOther() {
    document.getElementById("academicEdit").style.display = "none";
    document.getElementById("otherEdit").style.display = "flex";
    document.getElementById("requestedEdit").style.display = "none";
    localStorage.setItem('activeSection', 'otherEdit');
}
function showRequested() {
    document.getElementById("academicEdit").style.display = "none";
    document.getElementById("otherEdit").style.display = "none";
    document.getElementById("requestedEdit").style.display = "flex";
    localStorage.setItem('activeSection', 'requestedEdit');
}