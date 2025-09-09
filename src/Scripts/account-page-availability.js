const availabilityButton = document.getElementById("changeavailability");
const popupdiv = document.getElementById("availability-popup");

var isActive = false; // Whether the popup is shown
var isShown = false; // Whether the calendar is shown

availabilityButton.addEventListener("click", () => {
    if (isActive) {
        // Panel is currently visible and needs to be removed
        popupdiv.classList.add("hidden");
        isActive = false;
    } else {
        // Panel is currently hidden and needs to be shown
        popupdiv.classList.remove("hidden");
        isActive = true;
    }
});

const dailyButton = document.getElementById("daily");
const weeklyButton = document.getElementById("weekly");
const availabilitydiv = document.getElementById("availability"); // Element to store the calendar widget

dailyButton.addEventListener("click", () => {
    if (!isShown) {
        // Just in case the css is sensitive
        availabilitydiv.textContent = "";
        const table = document.createElement("p");
        table.textContent = "Testing";

        availabilitydiv.appendChild(table);
    }
});
