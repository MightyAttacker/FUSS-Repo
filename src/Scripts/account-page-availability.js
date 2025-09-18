import {
    availabilityButton,
    popupdiv,
    dailyButton,
    weeklyButton,
    availabilitydiv,
} from "./account-page-element-values.js";

var isActive = false; // Whether the popup is shown
var isShown = false; // Whether the calendar is shown

const days = ["Mon", "Tues", "Wed", "Thur", "Fri", "Sat", "Sun"];
let places = []; // Will have each <td> containing <div>s containing <input>s. Index matches day list above
let timesToSubmit = []; // Will hold the objects representing the availability for each day of the week
let currentStartDate = ""; // Will store the start date since the date picker can change without confirming

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

function createButtonDay(parent, day, storage) {
    const place = document.createElement("td");
    const more = document.createElement("button");
    more.setAttribute("id", day + "more");
    more.innerText = "+";

    more.addEventListener("click", () => {
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

        const end = document.createElement("input");
        end.setAttribute("type", "time");
        end.setAttribute("id", day + "end");

        div.appendChild(start);
        div.appendChild(end);

        storage.appendChild(div);
    });

    place.appendChild(more);
    parent.appendChild(place);
}

function validate() {
    timesToSubmit = [];

    var day = 0;
    // for each td
    places.forEach((td) => {
        // for each div
        for (let i = 0; i < td.children.length; i++) {
            var div = td.children[i];
            let start = div.children[1]; // Child[0] is the delete button
            let end = div.children[2];

            if (start.value === "" && end.value === "") {
                // If both are empty, skip it
            } else if (start.value === "" || end.value === "") {
                // If one is empty, it is invalid
                timesToSubmit = [];
                return false;
            } else if (start.value > end.value) {
                // If end time is less than start time
                timesToSubmit = [];
                return false;
            } else {
                timesToSubmit.push(new dailyrecurringAvailability("testuser1", day, start.value, end.value));
                // timesToSubmit.get(day).push([start.value, end.value]);
            }
        }
        day++;
    });
    console.log(timesToSubmit);
    return true;
}

function submit() {
    let temp = new weeklyRecurringAvailability(currentStartDate, timesToSubmit);

    // Below taken from https://www.index.dev/blog/javascript-post-requests-send-data-variables
    fetch("update-availability.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(temp),
    }).then((data) => console.log("Success:", data));
}

// function submit() {
//     // Below taken from https://www.index.dev/blog/javascript-post-requests-send-data-variables
//     fetch("update-availability.php", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//         },
//         body: JSON.stringify({
//             mon: timesToSubmit.get(0),
//             tues: timesToSubmit.get(1),
//             wed: timesToSubmit.get(2),
//             thur: timesToSubmit.get(3),
//             fri: timesToSubmit.get(4),
//             sat: timesToSubmit.get(5),
//             sun: timesToSubmit.get(6),
//         }),
//     }).then((data) => console.log("Success:", data));
// }

function getAvailability(startdate) {
    let t = fetch(
        "get-availability.php?startdate=" + startdate + "&id=testuser1",
        {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        }
    )
        .then((response) => response.json())
        .then((data) => {
            return data;
        });
    return t;
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
    // "By Week" button in popup. May need to take some of the functionality out
    if (!isShown) {
        isShown = true;
        availabilitydiv.textContent = ""; // Clear the div

        const label = document.createElement("p");
        label.innerText = "Choose Monday starting date for availability: ";

        const datePicker = document.createElement("input");
        datePicker.setAttribute("type", "date");
        datePicker.setAttribute("min", "2025-01-06");
        datePicker.setAttribute("step", "7");

        const confirmDate = document.createElement("button");
        confirmDate.innerText = "Confirm Date";

        confirmDate.addEventListener("click", () => {
            if (datePicker.value !== "") {
                // TODO: convert date to previous Monday
                currentStartDate = datePicker.value;
                console.log(getAvailability(datePicker.value)); // TODO: Fill table with values from here
            } else {
                alert("Choose a valid date"); // TODO: Change warning to something better
            }
        });

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

        const confirm = document.createElement("button");
        confirm.innerText = "Confirm Availability";
        confirm.addEventListener("click", () => {
            if (validate()) {
                console.log("success"); // TODO: remove this once program is working
                submit();
            }
        });

        availabilitydiv.appendChild(label);
        availabilitydiv.appendChild(datePicker);
        availabilitydiv.appendChild(confirmDate);
        availabilitydiv.appendChild(table);
        availabilitydiv.appendChild(confirm);
    }
});
