function validateField(element) {
    const id = element.id || element.name;
    const errorElement = document.getElementById(`${id}Error`);
    let isValid = true;

    if (element.type === 'text' || element.type === 'email' || element.type === 'tel' || element.type === 'textarea') {
        if (!element.value.trim()) {
            errorElement.style.display = 'block';
            isValid = false;
        } else {
            errorElement.style.display = 'none';
        }
    }

    if (element.type === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(element.value.trim())) {
            errorElement.style.display = 'block';
            isValid = false;
        }
    }

    if (element.id === 'phone') {
        const phoneRegex = /^\+?\d{10,15}$/;
        if (!phoneRegex.test(element.value.trim())) {
            errorElement.style.display = 'block';
            isValid = false;
        }
    }

    if (element.id === 'height') {
        const height = element.value.trim();
        if (!height || isNaN(height) || height <= 0) {
            errorElement.style.display = 'block';
            isValid = false;
        }
    }

    if (element.type === 'select-one') {
        if (!element.value) {
            errorElement.style.display = 'block';
            isValid = false;
        } else {
            errorElement.style.display = 'none';
        }
    }

    if (element.name === 'gender') {
        const gender = document.querySelector('input[name="gender"]:checked');
        const genderError = document.getElementById('genderError');
        if (!gender) {
            genderError.style.display = 'block';
            isValid = false;
        } else {
            genderError.style.display = 'none';
        }
    }

    if (element.name === 'hobbies') {
        const hobbies = document.querySelectorAll('input[name="hobbies"]:checked');
        const hobbiesError = document.getElementById('hobbiesError');
        if (hobbies.length === 0) {
            hobbiesError.style.display = 'block';
            isValid = false;
        } else {
            hobbiesError.style.display = 'none';
        }
    }

    if (element.id === 'dob') {
        if (!element.value) {
            errorElement.style.display = 'block';
            isValid = false;
        } else {
            errorElement.style.display = 'none';
        }
    }

    return isValid;
}

function validateTable() {
    const rows = document.querySelectorAll('#educationBody tr');
    let isValid = false;
    const errorElement = document.getElementById('educationError');

    for (const row of rows) {
        const degree = row.querySelector('input[name="degree"]').value.trim();
        const institution = row.querySelector('input[name="institution"]').value.trim();
        const year = row.querySelector('input[name="year"]').value.trim();
        if (degree && institution && year && !isNaN(year) && year.length === 4) {
            isValid = true;
            break;
        }
    }

    errorElement.style.display = isValid ? 'none' : 'block';
    return isValid;
}

function addEducationRow() {
    const tableBody = document.getElementById('educationBody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="text" name="degree" class="education-input" oninput="validateTable()"></td>
        <td><input type="text" name="institution" class="education-input" oninput="validateTable()"></td>
        <td><input type="text" name="year" class="education-input" oninput="validateTable()"></td>
        <td><button type="button" onclick="this.parentElement.parentElement.remove(); validateTable()">Remove</button></td>
    `;
    tableBody.appendChild(newRow);
    validateTable();
}

function validateForm(event) {
    event.preventDefault();
    let isValid = true;

    const fields = [
        'fullName', 'fatherName', 'motherName', 'dob', 'nationality',
        'maritalStatus', 'height', 'religion', 'occupation', 'email', 'phone', 'about'
    ];

    fields.forEach(id => {
        const element = document.getElementById(id);
        if (!validateField(element)) {
            isValid = false;
        }
    });

    if (!validateField({ name: 'gender' })) {
        isValid = false;
    }

    if (!validateField({ name: 'hobbies' })) {
        isValid = false;
    }

    if (!validateTable()) {
        isValid = false;
    }

    if (isValid) {
        alert('Form submitted successfully!');
        document.getElementById('biodataForm').reset();
        document.getElementById('educationBody').innerHTML = `
            <tr>
                <td><input type="text" name="degree" class="education-input" oninput="validateTable()"></td>
                <td><input type="text" name="institution" class="education-input" oninput="validateTable()"></td>
                <td><input type="text" name="year" class="education-input" oninput="validateTable()"></td>
                <td><button type="button" onclick="addEducationRow()">Add</button></td>
            </tr>
        `;
    }

    return isValid;
}

// Initial validation on page load
document.querySelectorAll('input, select, textarea').forEach(element => {
    element.addEventListener('input', () => validateField(element));
});