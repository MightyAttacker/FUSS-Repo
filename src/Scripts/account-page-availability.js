import {
    availabilityButton,
    popupdiv,
    dailyButton,
    weeklyButton,
    availabilitydiv,
} from "./account-page-element-values.js";

var isActive = false; // Whether the popup is shown
var isShown = false; // Whether the calendar is shown

function createRow(parent) {
    const row = document.createElement("tr");
    parent.appendChild(row);
    return row;
}

function createHeaderDay(parent, day) {
    const place = document.createElement("td");
    place.innerText = day;
    parent.appendChild(place);
    return place;
}

function createCalendarDay(parent, day) {
    const place = document.createElement("td");
    place.setAttribute("id", day + "place");

    parent.appendChild(place);
    return place;
}

function createButtonDay(parent, day, storage) {
    const place = document.createElement("td");
    const more = document.createElement("button");
    more.setAttribute("id", day + "more");
    more.innerText = "+";
    var numTimes = 0;

    more.addEventListener("click", () => {
        const div = document.createElement("div");
        const del = document.createElement("button");
        del.innerText = "-";
        del.setAttribute("id", day + "delete" + numTimes);

        del.addEventListener("click", () => {
            div.remove();
        });

        div.appendChild(del);

        const start = document.createElement("input");

        start.setAttribute("type", "time");
        start.setAttribute("id", day + "start" + numTimes);

        const end = document.createElement("input");
        end.setAttribute("type", "time");
        end.setAttribute("id", day + "end" + numTimes);

        div.appendChild(start);
        div.appendChild(end);

        storage.appendChild(div);
        
        place.appendChild(more);
        numTimes++;
    });

    place.appendChild(more);
    parent.appendChild(place);
}

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

weeklyButton.addEventListener("click", () => {
    if (!isShown) {
        // Just in case the css is sensitive
        isShown = true;
        availabilitydiv.textContent = ""; // Clear the div
        const table = document.createElement("table");
        table.classList.add("table");
        const days = ["Mon", "Tues", "Wed", "Thur", "Fri", "Sat", "Sun"];
        let places = [];

        const row = createRow(table);
        const calendarRow = createRow(table);
        const buttonRow = createRow(table);

        days.forEach((day) => {
            createHeaderDay(row, day);
            let temp = createCalendarDay(calendarRow, day);
            places.push(temp);
            createButtonDay(buttonRow, day, temp);
        });

        availabilitydiv.appendChild(table);
    }
});
