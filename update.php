<?php
include 'db.php';

$id = $_GET['id'] ?? 0;

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM biodata WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Record not found.");
}

// Handle update form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName      = $_POST['fullName'];
    $fatherName    = $_POST['fatherName'];
    $motherName    = $_POST['motherName'];
    $dob           = $_POST['dob'];
    $gender        = $_POST['gender'];
    $nationality   = $_POST['nationality'];
    $maritalStatus = $_POST['maritalStatus'];
    $height        = $_POST['height'];
    $religion      = $_POST['religion'];
    $occupation    = $_POST['occupation'];
    $email         = $_POST['email'];
    $phone         = $_POST['phone'];
    $about         = $_POST['about'];
    $hobbies       = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : '';

    // Education (skip for simplicity, can be updated separately)
    $stmt2 = $conn->prepare(
        "UPDATE biodata SET 
        fullName=?, fatherName=?, motherName=?, dob=?, gender=?, nationality=?, maritalStatus=?, 
        height=?, religion=?, occupation=?, email=?, phone=?, hobbies=?, about=? 
        WHERE id=?"
    );
    $stmt2->bind_param("sssssssissssssi", 
        $fullName, $fatherName, $motherName, $dob, $gender, $nationality, $maritalStatus,
        $height, $religion, $occupation, $email, $phone, $hobbies, $about, $id
    );

    if ($stmt2->execute()) {
        header("Location: read.php");
        exit;
    } else {
        echo "Update failed: " . $stmt2->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Biodata</title>
</head>
<body>
    <h2>Edit Biodata</h2>
    <form method="POST">
        Full Name: <input type="text" name="fullName" value="<?= htmlspecialchars($data['fullName']) ?>"><br>
        Father's Name: <input type="text" name="fatherName" value="<?= htmlspecialchars($data['fatherName']) ?>"><br>
        Mother's Name: <input type="text" name="motherName" value="<?= htmlspecialchars($data['motherName']) ?>"><br>
        Date of Birth: <input type="date" name="dob" value="<?= $data['dob'] ?>"><br>
        Gender: <input type="text" name="gender" value="<?= htmlspecialchars($data['gender']) ?>"><br>
        Nationality: <input type="text" name="nationality" value="<?= htmlspecialchars($data['nationality']) ?>"><br>
        Marital Status: <input type="text" name="maritalStatus" value="<?= htmlspecialchars($data['maritalStatus']) ?>"><br>
        Height: <input type="number" name="height" value="<?= $data['height'] ?>"><br>
        Religion: <input type="text" name="religion" value="<?= htmlspecialchars($data['religion']) ?>"><br>
        Occupation: <input type="text" name="occupation" value="<?= htmlspecialchars($data['occupation']) ?>"><br>
        Email: <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>"><br>
        Phone: <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>"><br>
        Hobbies: <input type="text" name="hobbies[]" value="<?= htmlspecialchars($data['hobbies']) ?>"><br>
        About: <textarea name="about"><?= htmlspecialchars($data['about']) ?></textarea><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
