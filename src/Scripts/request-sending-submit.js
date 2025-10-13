import {title, datetime, credits, notes, submit} from "/Scripts/request-sending-element-values.js";

class request {
    constructor(title, date, time, cost, notes, requester, requestee) {
        this.title = title;
        this.date = date;
        this.time = time;
        this.cost = cost;
        this.notes = notes;
        this.requester = requester;
        this.requestee = requestee;
    }
}

function validateForm() {
    if (title.value === "") {
        console.log("Title is empty");
        return false;
    }
    if (datetime.value === "") {
        console.log("date is empty");
        return false;
    }
    if (credits.value === "" || credits.value === "0") {
        console.log("credits");
        return false
    }
    return true;

}

function submitForm(){
    let temp = new request(title.value,
        datetime.value.substring(0, 10), // Date
        datetime.value.substring(11, 16), // Time
        parseInt(credits.value),
        notes.value,
        "testuser1",
        "testuser2");

    fetch("/api/create-request.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(temp)
    }).then((data) => console.log("Success: ", data));
}


submit.addEventListener("click", () => {
    console.log("Test");
    if (validateForm()) {
        submitForm();
    }
});