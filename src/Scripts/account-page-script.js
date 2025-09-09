//TODO: When finished, duplicate everything for non-academic skills
const academicSkills = document.getElementById("askills");

const selectedAcademicSkills_div = document.getElementById("academic-skills");

var userAcademicSkills = [];

function list_contains(list, value) {
    for (let i = 0; i < list.length; i++) {
        if (list[i] === value) {
            return true;
        }
    }
    return false;
}

academicSkills.addEventListener("change", () => {
    if (academicSkills.value !== "") {
        if (!list_contains(userAcademicSkills, academicSkills.value)) {
            userAcademicSkills.push(academicSkills.value);
            const newSkill = document.createElement("button");
            const id = document.createAttribute("id");
            const elementClass = document.createAttribute("class");
            const form = document.createAttribute("form"); // Removes the buttons from the form

            id.value = academicSkills.value;
            form.value = "";
            elementClass.value = "skill-btn academic-skill-btn";
            newSkill.setAttributeNode(id);
            newSkill.setAttributeNode(form);
            newSkill.setAttributeNode(elementClass);
            newSkill.innerText = academicSkills.value;

            selectedAcademicSkills_div.appendChild(newSkill);

            newSkill.addEventListener("click", () => {
                var test = id.value; // Stores the value of the id once the block is out of scope
                newSkill.remove();
                userAcademicSkills.splice( // Remove skill from the list of skills
                    userAcademicSkills.indexOf(test), // was userAcademicSkills.indexOf(academicSkills.value). Turns out that updates the value as the page changes. If it couldn't be found, the last element would be deleted
                    1
                );
            });
        }
    }
});
