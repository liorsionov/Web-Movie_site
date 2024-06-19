<?php
include 'db.php'; 
session_start(); 

$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? 'all';
$userId = $_SESSION['userid'] ?? null; 

if (!$userId) {
    echo "Please log in to view movies.";
    exit; 
}

// Start building the SQL query
$sql = "SELECT Movies.MovieID, Movies.Title, Movies.Description, Movies.TokenCost, Movies.ThumbnailURL, Movies.MovieURL,
        EXISTS(SELECT 1 FROM Purchases WHERE Purchases.MovieID = Movies.MovieID AND Purchases.UserID = ?) AS Purchased
        FROM Movies WHERE 1=1";

// Add search criteria
if (!empty($search)) {
    $sql .= " AND Title LIKE ?";
}

// Add filter criteria
if ($filter != 'all') {
    $sql .= " AND Genre = ?";
}

// Prepare the SQL statement
$stmt = $conn->prepare($sql);

// Create an array to hold the bind parameters
$params = [$userId];
$param_type = 'i'; // Starting with integer for user ID

// Add parameters for search and filter
if (!empty($search)) {
    $params[] = '%' . $search . '%';
    $param_type .= 's'; // Add string type for search
}
if ($filter != 'all') {
    $params[] = $filter;
    $param_type .= 's'; // Add string type for filter
}

// Bind parameters dynamically
$stmt->bind_param($param_type, ...$params);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4 col-sm-6 mb-4'>";
        echo "<div class='card'>";
        echo "<img class='card-img-top' src='" . $row["ThumbnailURL"] . "' alt='Movie Image' style='height: 200px;'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row["Title"] . "</h5>";
        echo "<p class='card-text'>" . $row["Description"] . "</p>";
        echo "<p class='card-text'><small class='text-muted'>Cost: " . $row["TokenCost"] . " Tokens</small></p>";
        echo "<a href='purchase_movie.php?movieId=" . $row["MovieID"] . "' class='btn btn-primary'>Buy Now</a>";
        
        if ($row['Purchased']) {
            echo "<a href='" . $row["MovieURL"] . "' class='btn btn-secondary' target='_blank'>Watch Now</a>";
            echo "<form action='submit_review.php' method='post' class='mt-3'>";
            echo "<input type='hidden' name='movieId' value='" . $row["MovieID"] . "'>";
            echo "<select name='rating' required>";
            echo "<option value=''>Rate...</option>";
            echo "<option value='1'>1</option>";
            echo "<option value='2'>2</option>";
            echo "<option value='3'>3</option>";
            echo "<option value='4'>4</option>";
            echo "<option value='5'>5</option>";
            echo "</select>";
            echo "<textarea name='reviewText' placeholder='Enter your review here...' required></textarea>";
            echo "<button type='submit' class='btn btn-success'>Submit Review</button>";
            echo "</form>";
        }
        
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<div class='col-12'><p>No movies found.</p></div>";
}

$stmt->close();
$conn->close(); 
?>
