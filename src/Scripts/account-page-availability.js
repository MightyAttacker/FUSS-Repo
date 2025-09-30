// TODO: work out how to let user view all availabilities
// TODO: make visualisation of availabilities

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
let currentEndDate = "";
let currentTableDiv;

// TODO: Move these to separate file
class dailyRecurringAvailability {
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

class dailyAvailability {
    constructor(userid, date, starttime, endtime) {
        this.userid = userid;
        this.date = date;
        this.starttime = starttime;
        this.endtime = endtime;
    }
}

class dailyAvailabilityCollection {
    constructor(startdate, enddate, days) {
        this.startdate = startdate;
        this.enddate = enddate;
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
    if (day) {
        start.setAttribute("id", day + "start");
    }
    if (startvalue) {
        start.setAttribute("value", startvalue);
    }

    const end = document.createElement("input");
    end.setAttribute("type", "time");
    if (day) {
        end.setAttribute("id", day + "end");
    }
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
    more.setAttribute("class", "more");
    more.innerText = "+";

    more.addEventListener("click", () => {
        createTimeSelector(storage, day);
    });

    place.appendChild(more);
    parent.appendChild(place);
    return place;
}

function validateAvailability(recurring = true) {
    timesToSubmit = [];

    let day = 0;
    let retval = true;
    console.log(places);
    // for each td
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
                console.log("test");
                if (recurring) {
                    timesToSubmit.push(new dailyRecurringAvailability("testuser1", day, start.value, end.value));
                } else {
                    let t = new dailyAvailability("testuser1", ((d) => {
                        d.setDate(d.getDate() + day);
                        return d.toISOString().substring(0, 10); // returns YYYY-MM-DD
                    })
                    (new Date(currentStartDate)), start.value, end.value);
                    timesToSubmit.push(t);
                }
            }
        }
        day++;
    });
    return retval;
}

function submitRecurringAvailability() {
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

function getRecurringAvailability(startdate, userid) {
    return fetch(
        // TODO: Use https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams
        "/api/get-recurring-availability.php?weekstartdate=" + startdate + "&userid=" + userid,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        }
    )
        .then((response) => response.json())
        .then((data) => { // TODO: check if this needs to be here
            return data;
        });
}

function getDailyAvailability(startdate, enddate, userid) {
    return fetch(
        // TODO: Use https://developer.mozilla.org/en-US/docs/Web/API/URLSearchParams
        "/api/get-daily-availability.php?startdate=" + startdate + "&userid=" + userid + "&enddate=" + enddate,
        {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        }
    )
        .then((response) => response.json())
        .then((data) => { // TODO: check if this needs to be here
            return data;
        });
}

function submitDailyAvailability() {
    if (currentStartDate === "" || currentEndDate === "") {
        return false;
    }
    const temp = new dailyAvailabilityCollection(currentStartDate, currentEndDate, timesToSubmit);
    // Below taken from https://www.index.dev/blog/javascript-post-requests-send-data-variables
    fetch("/api/update-daily-availability.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(temp),
    }).then((data) => console.log("Success:", data));
}

function insertRecurringAvailability(weeklyavailability) {
    // Use the places[dayindex] to figure out where to put divs
    // Potentially sort by starttime
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
    if (true) {
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

                    getRecurringAvailability(datePicker.value, "testuser1").then((data) => insertRecurringAvailability(data));

                    const confirm = document.createElement("button"); // TODO: make this independent from the table
                    confirm.innerText = "Confirm Availability";
                    confirm.addEventListener("click", () => {
                        if (validateAvailability()) {
                            submitRecurringAvailability();
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
    if (true) { // Work out conditions to add widget. Maybe just delete whatever is there
        availabilitydiv.innerHTML = "";
        popupdiv.classList.add("hidden"); // Hide popup once button is clicked
        popupActive = false;

        const startdate = document.createElement("input"); // TODO: add id and class to these
        startdate.setAttribute("type", "date");

        const enddate = document.createElement("input");
        enddate.setAttribute("type", "date");

        const confirmDates = document.createElement("button");
        confirmDates.innerText = "Confirm Dates";

        confirmDates.addEventListener("click", () => {
            // TODO: date validation
            currentStartDate = startdate.value;
            currentEndDate = enddate.value;

            if (currentStartDate < currentEndDate) {
                let current = new Date(startdate.value);
                const end = new Date(enddate.value);

                const table = document.createElement("table");

                while (current <= end) {
                    const row = document.createElement("tr");
                    const label = document.createElement("td");
                    label.innerText = current.toDateString();

                    const input = document.createElement("td"); // Will contain divs containing input elements
                    input.setAttribute("id", current.toISOString().substring(0, 10));
                    places.push(input);
                    createButtonDay(row, current.toISOString().substring(0, 10), input);

                    row.appendChild(label);
                    row.appendChild(input);

                    table.appendChild(row);
                    current.setDate(current.getDate() + 1);
                }

                getDailyAvailability(currentStartDate, currentEndDate, "testuser1").then((data) => {
                    console.log(data);
                    for (let i = 0; i < data["days"].length; i++) {
                        createTimeSelector(document.getElementById(data["days"][i]["d"]), "", data["days"][i]["starttime"], data["days"][i]["endtime"]);
                    }
                });


                availabilitydiv.appendChild(table);
                const submit = document.createElement("button");
                submit.innerText = "Submit Availability";
                submit.addEventListener("click", () => {
                    if (validateAvailability(false)) { // false means the dates are for daily availabilities
                        submitDailyAvailability();
                    } else {
                        console.log("fail");
                    }
                });
                availabilitydiv.appendChild(submit);
            } else {
                alert("start date must be earlier than end date");
            }
        });

        availabilitydiv.appendChild(startdate);
        availabilitydiv.appendChild(enddate);
        availabilitydiv.appendChild(confirmDates);
    }
});