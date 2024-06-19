<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in to view this page.'); window.location.href = 'login.html';</script>";
    exit;
}

$userId = $_SESSION['userid'];

// Fetch user data
$sql = "SELECT Username, Email, Tokens FROM Users WHERE UserID = '$userId'";
$userResult = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
<?php
if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    echo "<h1 class='mb-3'>Profile Page</h1>";
    echo "<p>Username: " . htmlspecialchars($userData['Username']) . "</p>";
    echo "<p>Email: " . htmlspecialchars($userData['Email']) . "</p>";
    echo "<p>Tokens: " . htmlspecialchars($userData['Tokens']) . "</p>";

    // Profile update form
    echo "<h2>Update Profile</h2>";
    echo "<form method='post' action='update_profile.php' class='mb-3'>";
    echo "<div class='mb-3'><label class='form-label'>Username</label><input type='text' class='form-control' name='username' value='" . htmlspecialchars($userData['Username']) . "' required></div>";
    echo "<div class='mb-3'><label class='form-label'>Email</label><input type='email' class='form-control' name='email' value='" . htmlspecialchars($userData['Email']) . "' required></div>";
    echo "<button type='submit' class='btn btn-primary'>Update</button>";
    echo "</form>";

    echo "<a href='index.php' class='btn btn-secondary'>Return to Main Page</a>";

    echo "<h2>Buy Tokens</h2>";
    echo "<form method='post' action='buy_tokens.php'>";
    echo "<select name='token_amount' class='form-control'>";
    echo "<option value='100'>100 Tokens</option>";
    echo "<option value='200'>200 Tokens</option>";
    echo "<option value='500'>500 Tokens</option>";
    echo "<option value='1000'>1000 Tokens</option>";
    echo "</select>";
    echo "<button type='submit' class='btn btn-success'>Buy Tokens</button>";
    echo "</form>";

    // Fetch purchase history
    $sql = "SELECT Movies.Title, Purchases.PurchaseDate FROM Purchases JOIN Movies ON Purchases.MovieID = Movies.MovieID WHERE Purchases.UserID = '$userId'";
    $purchaseResult = $conn->query($sql);

    echo "<h2>Purchase History</h2>";
    if ($purchaseResult->num_rows > 0) {
        while ($row = $purchaseResult->fetch_assoc()) {
            echo "<p>" . htmlspecialchars($row['Title']) . " - Purchased on: " . htmlspecialchars($row['PurchaseDate']) . "</p>";
        }
    } else {
        echo "<p>No purchases made yet.</p>";
    }
} else {
    echo "User profile not found.";
}
?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
