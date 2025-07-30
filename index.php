<?php
include 'db.php';


<html lang="en">

<body>
    <div class="form-container">
        <h1>Marriage Biodata</h1>
        <form action="create.php" method="POST">

            
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" id="fullName" name="fullName" required>
            </div>

            <div class="form-group">
                <label for="fatherName">Father's Name</label>
                <input type="text" id="fatherName" name="fatherName" required>
            </div>

            <div class="form-group">
                <label for="motherName">Mother's Name</label>
                <input type="text" id="motherName" name="motherName" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <div class="radio-group">
                    <input type="radio" id="male" name="gender" value="male" required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender" value="other">
                    <label for="other">Other</label>
                </div>
            </div>

            <div class="form-group">
                <label for="nationality">Nationality</label>
                <input type="text" id="nationality" name="nationality" required>
            </div>

            <div class="form-group">
                <label for="maritalStatus">Marital Status</label>
                <select id="maritalStatus" name="maritalStatus" required>
                    <option value="">Select Status</option>
                    <option value="never_married">Never Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                </select>
            </div>

            <div class="form-group">
                <label for="height">Height (in cm)</label>
                <input type="number" id="height" name="height" required>
            </div>

            <div class="form-group">
                <label for="religion">Religion</label>
                <input type="text" id="religion" name="religion" required>
            </div>

            <!-- Education Section -->
            <div class="form-group">
                <label>Education</label>
                <table id="educationTable">
                    <thead>
                        <tr>
                            <th>Degree</th>
                            <th>Institution</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="educationBody">
                        <tr>
                            <td><input type="text" name="education[degree][]" required></td>
                            <td><input type="text" name="education[institution][]" required></td>
                            <td><input type="text" name="education[year][]" required></td>
                            <td><button type="button" onclick="addEducationRow()">Add</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <label for="occupation">Occupation</label>
                <input type="text" id="occupation" name="occupation" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label>Hobbies</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="reading" name="hobbies[]" value="reading">
                    <label for="reading">Reading</label>
                    <input type="checkbox" id="traveling" name="hobbies[]" value="traveling">
                    <label for="traveling">Traveling</label>
                    <input type="checkbox" id="cooking" name="hobbies[]" value="cooking">
                    <label for="cooking">Cooking</label>
                    <input type="checkbox" id="sports" name="hobbies[]" value="sports">
                    <label for="sports">Sports</label>
                </div>
            </div>

            <div class="form-group">
                <label for="about">About Yourself</label>
                <textarea id="about" name="about" rows="5" required></textarea>
            </div>

            <button type="submit">Submit Biodata</button>
        </form>
    </div>
</body>
</html>


// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS biodata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(100),
    fatherName VARCHAR(100),
    motherName VARCHAR(100),
    dob DATE,
    gender VARCHAR(10),
    nationality VARCHAR(50),
    maritalStatus VARCHAR(20),
    height INT,
    religion VARCHAR(50),
    education TEXT,
    occupation VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    hobbies TEXT,
    about TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table biodata created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
