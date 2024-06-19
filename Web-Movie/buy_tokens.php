<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in to buy tokens.'); window.location.href = 'login.html';</script>";
    exit;
}

$userId = $_SESSION['userid'];
$tokenAmount = $_POST['token_amount'];

$sql = "UPDATE Users SET Tokens = Tokens + ? WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $tokenAmount, $userId);

if ($stmt->execute()) {
    echo "<script>alert('You have successfully purchased $tokenAmount tokens.'); window.location.href = 'profile.php';</script>";
} else {
    echo "Error updating tokens: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
