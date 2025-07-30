<?php
include 'db.php';

$sql = "SELECT * FROM biodata";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Biodata Records</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; margin: 5px; }
    </style>
</head>
<body>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['fullName']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td>
                    <a href="update.php?id=<?= $row['id'] ?>">✏️ Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">🗑 Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
