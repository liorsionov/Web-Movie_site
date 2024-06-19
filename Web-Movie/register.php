<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Please fill all the fields.'); window.location.href='register.html';</script>";
    } else {
        // Check if the username or email already exists in the database
        $sql = "SELECT * FROM Users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Username or Email already exists.'); window.location.href='register.html';</script>";
        } else {
            // If not found, insert the new user into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertSql = "INSERT INTO Users (Username, Email, Password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                echo "<script>alert('Registration successful! Please log in.'); window.location.href='login.html';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>
