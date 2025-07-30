<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName      = trim($_POST['fullName'] ?? '');
    $fatherName    = trim($_POST['fatherName'] ?? '');
    $motherName    = trim($_POST['motherName'] ?? '');
    $dob           = $_POST['dob'] ?? '';
    $gender        = $_POST['gender'] ?? '';
    $nationality   = trim($_POST['nationality'] ?? '');
    $maritalStatus = $_POST['maritalStatus'] ?? '';
    $height        = $_POST['height'] ?? 0;
    $religion      = trim($_POST['religion'] ?? '');
    $occupation    = trim($_POST['occupation'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $about         = trim($_POST['about'] ?? '');
    $hobbies       = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : '';

    $educationData = [];
    if (isset($_POST['education']['degree'])) {
        $count = count($_POST['education']['degree']);
        for ($i = 0; $i < $count; $i++) {
            $degree      = $_POST['education']['degree'][$i] ?? '';
            $institution = $_POST['education']['institution'][$i] ?? '';
            $year        = $_POST['education']['year'][$i] ?? '';
            if ($degree || $institution || $year) {
                $educationData[] = [
                    'degree'      => $degree,
                    'institution' => $institution,
                    'year'        => $year
                ];
            }
        }
    }
    $educationJSON = json_encode($educationData);

    $stmt = $conn->prepare("INSERT INTO biodata 
        (fullName, fatherName, motherName, dob, gender, nationality, maritalStatus, height, religion, education, occupation, email, phone, hobbies, about)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssssisssssss",
        $fullName, $fatherName, $motherName, $dob, $gender, $nationality,
        $maritalStatus, $height, $religion, $educationJSON,
        $occupation, $email, $phone, $hobbies, $about
    );
    if ($stmt->execute()) {
        echo "<h2 style='color:green;text-align:center;'>Biodata submitted successfully!</h2>";
        echo "<div style='text-align:center;'><a href='read.php'>View All Records</a></div>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Marriage Biodata Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
        }
        .container {
            background: #fff;
            padding: 30px;
            width: 600px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #444;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .gender, .hobbies {
            margin-bottom: 15px;
        }
        .gender label, .hobbies label {
            font-weight: normal;
            margin-right: 15px;
        }
        button {
            width: 100%;
            background: #007BFF;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Marriage Biodata</h2>
        <form action="create.php" method="POST">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="fatherName">Father's Name</label>
            <input type="text" id="fatherName" name="fatherName" required>

            <label for="motherName">Mother's Name</label>
            <input type="text" id="motherName" name="motherName" required>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>

            <label>Gender</label>
            <div class="gender">
                <input type="radio" id="male" name="gender" value="male" required>
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female">Female</label>
                <input type="radio" id="other" name="gender" value="other">
                <label for="other">Other</label>
            </div>

            <label for="nationality">Nationality</label>
            <input type="text" id="nationality" name="nationality" required>

            <label for="maritalStatus">Marital Status</label>
            <select id="maritalStatus" name="maritalStatus" required>
                <option value="">Select Status</option>
                <option value="never_married">Never Married</option>
                <option value="divorced">Divorced</option>
                <option value="widowed">Widowed</option>
            </select>

            <label for="height">Height (cm)</label>
            <input type="number" id="height" name="height" required>

            <label for="religion">Religion</label>
            <input type="text" id="religion" name="religion" required>

            <label>Education</label>
            <input type="text" name="education[degree][]" placeholder="Degree" required>
            <input type="text" name="education[institution][]" placeholder="Institution" required>
            <input type="text" name="education[year][]" placeholder="Year" required>

            <label for="occupation">Occupation</label>
            <input type="text" id="occupation" name="occupation" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required>

            <label>Hobbies</label>
            <div class="hobbies">
                <input type="checkbox" id="reading" name="hobbies[]" value="reading">
                <label for="reading">Reading</label>
                <input type="checkbox" id="traveling" name="hobbies[]" value="traveling">
                <label for="traveling">Traveling</label>
                <input type="checkbox" id="cooking" name="hobbies[]" value="cooking">
                <label for="cooking">Cooking</label>
                <input type="checkbox" id="sports" name="hobbies[]" value="sports">
                <label for="sports">Sports</label>
            </div>

            <label for="about">About Yourself</label>
            <textarea id="about" name="about" rows="5" required></textarea>

            <button type="submit">Submit Biodata</button>
        </form>
    </div>
</body>
</html>
