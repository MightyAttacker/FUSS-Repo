//TODO: When finished, duplicate everything for non-academic skills
const academicSkills = document.getElementById("askills");

const selectedAcademicSkills_div = document.getElementById("academic-skills");

var userAcademicSkills = [];

function list_contains(list, value) {
    for (let i = 0; i < list.length; i++) {
        const element = list[i];
        if (element === value) {
            return true;
        }
    }
    return false;
}

academicSkills.addEventListener("change", () => {
    if (academicSkills.value !== "") {
        if (!list_contains(userAcademicSkills, academicSkills.value)) {
            // New note: JS is retarded; 'in' does not check string values -- it checks indices
            userAcademicSkills.push(academicSkills.value);
            const newSkill = document.createElement("button");
            const id = document.createAttribute("id");
            const elementClass = document.createAttribute("class");
            const form = document.createAttribute("form"); // Removes the buttons from the form

            id.value = academicSkills.value;
            form.value = "";
            elementClass.value = "skill-btn academic-skill-btn"
            newSkill.setAttributeNode(id);
            newSkill.setAttributeNode(form);
            newSkill.setAttributeNode(elementClass);
            newSkill.innerText = academicSkills.value;

            selectedAcademicSkills_div.appendChild(newSkill);

            newSkill.addEventListener("click", () => {
                userAcademicSkills.splice(
                    userAcademicSkills.indexOf(academicSkills.value),
                    1
                );
                newSkill.remove();
            });
        }
    }
});
