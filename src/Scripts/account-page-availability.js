//TODO: work out how to let user view all availabilities
//TODO: make visualisation of availabilities

import {
    availabilityButton,
    availabilitydiv,
    dailyButton,
    popupdiv,
    weeklyButton,
} from "./account-page-element-values.js";

var popupActive = false; // Whether the popup is shown
var calendarShown = false; // Whether the calendar is shown

const days = ["Mon", "Tues", "Wed", "Thur", "Fri", "Sat", "Sun"];
let places = []; // Will have each <td> containing <div>s containing <input>s. Index matches day list above
let timesToSubmit = []; // Will hold the objects representing the availability for each day of the week
let currentStartDate = ""; // Will store the start date since the date picker can change without confirming
let currentTableDiv;

class dailyrecurringAvailability {
    constructor(userid, dayindex, starttime, endtime) {
        this.userid = userid;
        this.dayindex = dayindex;
        this.starttime = starttime;
        this.endtime = endtime;
    }
}

class weeklyRecurringAvailability {
    constructor(startdate, days) {
        this.weekstartdate = startdate;
        this.days = days;
    }
}

function createRow(parent) {
    const row = document.createElement("tr");
    parent.appendChild(row);
    return row;
}

function createHeaderDay(parent, day) {
    // Creates td with day label.
    const place = document.createElement("td");
    place.innerText = day; // TODO: make this stylable
    parent.appendChild(place);
    return place;
}

function createCalendarDay(parent, day) {
    // Creates tds to store divs which hold the time inputs
    const place = document.createElement("td");
    place.setAttribute("id", day + "place");
    parent.appendChild(place);
    return place;
}

function createTimeSelector(parent, day, startvalue="", endvalue = "") {
    const div = document.createElement("div");
    const del = document.createElement("button");
    del.innerText = "-";
    del.setAttribute("id", day + "delete");

    del.addEventListener("click", () => {
        div.remove();
    });

    div.appendChild(del);

    const start = document.createElement("input");

    start.setAttribute("type", "time");
    start.setAttribute("id", day + "start");
    if (startvalue) {
        start.setAttribute("value", startvalue);
    }

    const end = document.createElement("input");
    end.setAttribute("type", "time");
    end.setAttribute("id", day + "end");
    if (endvalue) {
        end.setAttribute("value", endvalue);
    }

    div.appendChild(start);
    div.appendChild(end);

    parent.appendChild(div);
    return div;
}

function createButtonDay(parent, day, storage) {
    const place = document.createElement("td");
    const more = document.createElement("button");
    more.setAttribute("id", day + "more");
    more.innerText = "+";

    more.addEventListener("click", () => {
        createTimeSelector(storage, day);
    });

    place.appendChild(more);
    parent.appendChild(place);
    return place;
}

function validate() {
    timesToSubmit = [];

    let day = 0;
    // for each td
    let retval = true;
    places.forEach((td) => {
        // for each div
        for (let i = 0; i < td.children.length; i++) {
            const div = td.children[i];
            let start = div.children[1]; // Child[0] is the delete button
            let end = div.children[2];

            if (start.value === "" && end.value === "") {
                // If both are empty, skip it
            } else if (start.value === "" || end.value === "") {
                // If one is empty, it is invalid
                timesToSubmit = [];
                retval = false;
            } else if (start.value > end.value) {
                // If end time is earlier than start time
                timesToSubmit = [];
                retval = false;
            } else {
                timesToSubmit.push(new dailyrecurringAvailability("testuser1", day, start.value, end.value));
            }
        }
        day++;
    });
    console.log(timesToSubmit);
    return retval;
}

function submit() {
    if (currentStartDate === "") { // If startdate is not set
        return false;
    }
    let temp = new weeklyRecurringAvailability(currentStartDate, timesToSubmit);

    // Below taken from https://www.index.dev/blog/javascript-post-requests-send-data-variables
    fetch("/api/update-recurring-availability.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(temp),
    }).then((data) => console.log("Success:", data));
}

function getAvailability(startdate, userid) {
    return fetch(
        // TODO: Use https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams
        "/api/get-availability.php?startdate=" + startdate + "&id=" + userid,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        }
    )
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            return data;
        });
}

function insertavailability(weeklyavailability) {
    // Use the places[dayindex] to figure out where to put divs
    // Potentially sort by starttime
    console.log(weeklyavailability);
    console.log(places);
    for (var i = 0; i < weeklyavailability.days.length; i++) {
        const dayindex = weeklyavailability.days[i].dayindex;
        const start = weeklyavailability.days[i].starttime; // TODO: remove seconds from value
        const end = weeklyavailability.days[i].endtime;
        createTimeSelector(places[dayindex], dayindex, start, end);
    }

}

availabilityButton.addEventListener("click", () => {
    if (popupActive) {
        // Panel is currently visible and needs to be removed
        popupdiv.classList.add("hidden");
        popupActive = false;
    } else {
        // Panel is currently hidden and needs to be shown
        popupdiv.classList.remove("hidden");
        popupActive = true;
    }
});

weeklyButton.addEventListener("click", () => {
    // "By Week" button in popup. May need to take some of the functionality out
    if (!calendarShown) {
        popupdiv.classList.add("hidden"); // Hide popup once button is clicked
        popupActive = false;

        calendarShown = true;
        availabilitydiv.textContent = ""; // Clear the div

        const label = document.createElement("p");
        label.innerText = "Choose Monday starting date for availability: ";

        const datePicker = document.createElement("input"); // TODO: make this button submit on enter
        datePicker.setAttribute("type", "date");
        datePicker.setAttribute("min", "2025-01-06");
        datePicker.setAttribute("step", "7");

        const confirmDate = document.createElement("button");
        confirmDate.innerText = "Confirm Date";
        let tableExists = false;

        confirmDate.addEventListener("click", () => {
            if (currentTableDiv) {
                currentTableDiv.remove();
                tableExists = false;
                currentStartDate = "";
                places = [];
            }
            if (!tableExists) { // TODO: work out if this condition needs to be there
                if (datePicker.value !== "") {
                    // TODO: convert date to previous Monday
                    currentStartDate = datePicker.value;
                    const div = document.createElement("div");
                    const table = document.createElement("table");
                    table.classList.add("table");

                    const row = createRow(table);
                    const calendarRow = createRow(table);
                    const buttonRow = createRow(table);

                    days.forEach((day) => {
                        createHeaderDay(row, day);
                        let temp = createCalendarDay(calendarRow, day);
                        places.push(temp);
                        createButtonDay(buttonRow, day, temp);
                    });

                    getAvailability(datePicker.value, "testuser1").then((data) => insertavailability(data));

                    const confirm = document.createElement("button"); // TODO: make this independent from the table
                    confirm.innerText = "Confirm Availability";
                    confirm.addEventListener("click", () => {
                        if (validate()) {
                            submit();
                        } else {
                            console.log("fail");
                        }
                    });

                    div.appendChild(confirm);

                    div.insertBefore(table, confirm)

                    availabilitydiv.appendChild(div);
                    tableExists = true;
                    currentTableDiv = div;

                } else {
                    alert("Choose a valid date"); // TODO: Change warning to something better; not an alert
                }
            }
        });
        availabilitydiv.appendChild(label);
        availabilitydiv.appendChild(datePicker);
        availabilitydiv.appendChild(confirmDate);
    }
});

dailyButton.addEventListener("click", () => {

});