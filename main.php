<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hearmony Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Hearmony Admin Dashboard</a>

    <!-- Navigation links -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Add an empty div with ml-auto to push the logout button to the right -->
        <div class="ml-auto"></div>
        
        <!-- Logout button -->
        <form class="form-inline my-2 my-lg-0" action="logout.php" method="post">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
        </form>
    </div>
</nav>


<!-- Your buttons in the middle of the screen -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <a href="article/view.php" class="btn btn-primary btn-lg btn-block">Article Manager</a>
            <a href="psikolog/view.php" class="btn btn-primary btn-lg btn-block">Psikolog Account Manager</a>
            <a href="cs/view.php" class="btn btn-primary btn-lg btn-block">Customer Service Manager</a>
            <a href="recommendation/view.php" class="btn btn-primary btn-lg btn-block">Goal Recommendation Manager</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js (optional) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
