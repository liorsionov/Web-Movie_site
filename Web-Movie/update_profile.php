<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in to update profile.'); window.location.href = 'login.html';</script>";
    exit;
}

$userId = $_SESSION['userid'];
$newUsername = $_POST['username'];
$newEmail = $_POST['email'];

// Prepare the SQL statement to prevent SQL injection
$sql = "UPDATE Users SET Username = ?, Email = ? WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $newUsername, $newEmail, $userId);

// Execute the statement and check if it was successful
if ($stmt->execute()) {
    echo "<script>alert('Profile updated successfully.'); window.location.href = 'profile.php';</script>";
} else {
    echo "<script>alert('Error updating profile: " . $stmt->error . "'); window.location.href = 'profile.php';</script>";
}

$stmt->close();
$conn->close();
?>
