<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web-Movie</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #007bff; }
        .navbar-brand, .nav-link { color: white !important; }
        .form-container { padding: 20px; background: #ffffff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,.1); margin-bottom: 20px; }
        .card { margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Web-Movie</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_movies.php">My Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="form-container">
            <form method="get" action="index.php" class="mb-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search movies..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                </div>
                <select name="filter" class="form-select mb-3">
                    <option value="all">All</option>
                    <option value="action" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'action') echo 'selected'; ?>>Action</option>
                    <option value="comedy" <?php if (isset($_GET['filter']) && $_GET['filter'] == 'comedy') echo 'selected'; ?>>Comedy</option>
                    <!-- Add other genres as needed -->
                </select>
            </form>
            <!-- Display Movies -->
            <?php include 'display_movies.php'; ?>
        </div>
    </main>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
