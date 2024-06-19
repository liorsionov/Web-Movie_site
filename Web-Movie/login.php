<?php
include 'db.php'; 
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Fetch user data securely
    $sql = "SELECT UserID, Username, Password FROM Users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['Password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userid'] = $row['UserID'];
            $_SESSION['username'] = $row['Username'];

            // Redirect to the main page
            header("Location: index.php");
            exit;
        } else {
            // Incorrect password, redirect back to login with an error message
            header("Location: login.html?error=Invalid password");
            exit;
        }
    } else {
        // No user found, redirect back to login with an error message
        header("Location: login.html?error=No user found with that username");
        exit;
    }
    $stmt->close();
    $conn->close();
}
?>
