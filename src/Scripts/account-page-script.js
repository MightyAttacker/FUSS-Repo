//TODO: When finished, duplicate everything for non-academic skills
function list_contains(list, value) {
    for (let i = 0; i < list.length; i++) {
        if (list[i] === value) {
            return true;
        }
    }
    return false;
}

export function createButton(skillname, academic) {
    if (academic) {
        if (!list_contains(userAcademicSkills, skillname)) {
            userAcademicSkills.push(skillname); // Assign skill to user
            const newSkill = document.createElement("button");
            const id = document.createAttribute("id"); // Need to find better way to add attributes; surely a dictionary can be used
            const elementClass = document.createAttribute("class");
            const form = document.createAttribute("form"); // Removes the buttons from the form

            id.value = skillname;
            form.value = "";
            elementClass.value = "skill-btn academic-skill-btn";
            newSkill.setAttributeNode(id);
            newSkill.setAttributeNode(form);
            newSkill.setAttributeNode(elementClass);
            newSkill.innerText = skillname;

            selectedAcademicSkills_div.appendChild(newSkill);

            newSkill.addEventListener("click", () => {
                var test = id.value; // Stores the value of the id once the block is out of scope
                newSkill.remove();
                userAcademicSkills.splice(
                    // Remove skill from the list of skills
                    userAcademicSkills.indexOf(test), // was userAcademicSkills.indexOf(academicSkills.value). Turns out that updates the value as the page changes. If it couldn't be found, the last element would be deleted
                    1
                );
            });
        }
    } else {
        if (!list_contains(userNonAcademicSkills, nonAcademicSkillsDropdown.value)) {
            userNonAcademicSkills.push(skillname);
            const newSkill = document.createElement("button");
            const id = document.createAttribute("id");
            const elementClass = document.createAttribute("class");
            const form = document.createAttribute("form"); // Removes the buttons from the form

            id.value = skillname;
            form.value = "";
            elementClass.value = "skill-btn non-academic-skill-btn";
            newSkill.setAttributeNode(id);
            newSkill.setAttributeNode(form);
            newSkill.setAttributeNode(elementClass);
            newSkill.innerText = skillname;

            selectedNonAcademicSkills_div.appendChild(newSkill);

            newSkill.addEventListener("click", () => {
                var test = id.value; // Stores the value of the id once the block is out of scope
                newSkill.remove();
                userNonAcademicSkills.splice(
                    // Remove skill from the list of skills
                    userNonAcademicSkills.indexOf(test), // was userAcademicSkills.indexOf(academicSkills.value). Turns out that updates the value as the page changes. If it couldn't be found, the last element would be deleted
                    1
                );
            });
        }
    }
}

const academicSkills = document.getElementById("askills"); // Dropdown with all of the skills

const selectedAcademicSkills_div = document.getElementById("academic-skills"); // Div to put the buttons in

export var userAcademicSkills = []; // List to store current academic skills


academicSkills.addEventListener("change", () => {
    if (academicSkills.value !== "") {
        createButton(academicSkills.value, true);
    }
});

// Duplicated for non-academic skills

const nonAcademicSkillsDropdown = document.getElementById("naskills");

const selectedNonAcademicSkills_div = document.getElementById(
    "non-academic-skills"
);

export var userNonAcademicSkills = [];
nonAcademicSkillsDropdown.addEventListener("change", () => {
    if (nonAcademicSkillsDropdown.value !== "") {
        createButton(nonAcademicSkillsDropdown.value, false);
    }
});
