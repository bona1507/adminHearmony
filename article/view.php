<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../index.php");
    exit();
}
include("../db/config.php");
include("../db/firebaseRDB.php");
$db = new firebaseRDB($databaseURL);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hearmony Article Manager</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Hearmony Admin Dashboard</a>

    <!-- Button for toggling responsive navigation -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation links -->
    <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Add an empty div with ml-auto to push the logout button to the right -->
        <div class="ml-auto"></div>
        
        <!-- Logout button -->
        <form class="form-inline my-2 my-lg-0" action="../logout.php" method="post">
            <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <a href="add.php" class="btn btn-primary">Add Article</a><br><br>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">Thumbnail</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Category</th>
                <th scope="col">Editor</th>
                <th scope="col">Author</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = $db->retrieve("article");
            $decodedData = json_decode($data, true);

            if (is_array($decodedData)) {
                foreach ($decodedData as $id => $article) {
                    if (is_array($article)) {
                        echo "<tr>
                                <td><img src='{$article['thumbnail']}' style='max-width: 100px; max-height: 100px;'></td>
                                <td>{$article['title']}</td>
                                <td>{$article['content']}</td>
                                <td>{$article['category']}</td>
                                <td>{$article['editor']}</td> 
                                <td>{$article['author']}</td> 
                                <td><a href='edit.php?id=$id' class='btn btn-warning'>EDIT</a></td>
                                <td><a href='delete.php?id=$id' class='btn btn-danger'>DELETE</a></td>
                              </tr>";
                    } else {
                        // Handle the case where $article is not an array (perhaps log an error)
                        echo "<tr><td colspan='7'>Invalid article format</td></tr>";
                    }
                }
            } else {
                // Handle the case where decoding failed (perhaps log an error)
                echo "<tr><td colspan='7'>Error decoding data from Firebase</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js (optional) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
