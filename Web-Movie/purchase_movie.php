<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "You must be logged in to purchase movies.";
    exit;
}

$movieId = $_GET['movieId'];
$userId = $_SESSION['userid'];

// Fetch the cost of the movie
$sql = "SELECT TokenCost FROM Movies WHERE MovieID = $movieId";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $movieCost = $row['TokenCost'];

    // Check user's token balance
    $sql = "SELECT Tokens FROM Users WHERE UserID = $userId";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $userTokens = $row['Tokens'];

    if ($userTokens >= $movieCost) {
        // Deduct the cost and update user tokens
        $newBalance = $userTokens - $movieCost;
        $sql = "UPDATE Users SET Tokens = $newBalance WHERE UserID = $userId";
        $conn->query($sql);

        // Record the purchase
        $sql = "INSERT INTO Purchases (UserID, MovieID, PurchaseDate) VALUES ($userId, $movieId, NOW())";
        if ($conn->query($sql)) {
            echo "Purchase successful! Remaining Tokens: $newBalance";
        } else {
            echo "Error recording purchase: " . $conn->error;
        }
    } else {
        echo "Insufficient tokens.";
    }
} else {
    echo "Movie not found.";
}

$conn->close();
?>
