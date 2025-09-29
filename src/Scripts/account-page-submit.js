import { userAcademicSkills, userNonAcademicSkills } from "./account-page-script.js";
import {courseName, about, submitButton} from "./account-page-element-values.js";
// Below taken from https://www.index.dev/blog/javascript-post-requests-send-data-variables

submitButton.addEventListener("click", () => {
    submit();
});

function submit() {
    console.log("start");
    fetch("/api/update-details.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            course: courseName.value,
            about: about.value,
            askills: userAcademicSkills,
            naskills: userNonAcademicSkills
        })
    })
    .then(data => console.log("Success:", data));
    console.log("end");
}