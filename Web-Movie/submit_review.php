<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "Please log in to submit reviews.";
    exit;
}

$userId = $_SESSION['userid'];
$movieId = $_POST['movieId'];
$rating = $_POST['rating'];
$reviewText = $conn->real_escape_string($_POST['reviewText']);

$sql = "INSERT INTO Reviews (MovieID, UserID, Rating, ReviewText) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $movieId, $userId, $rating, $reviewText);
if ($stmt->execute()) {
    echo "Review submitted successfully!";
} else {
    echo "Error submitting review: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
