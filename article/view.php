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
    <a href="add.php" class="btn btn-primary">Add New Account</a><br><br>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">Thumbnail</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Roles</th>
                <th scope="col">Office Location</th>
                <th scope="col">Profile Description</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $data = $db->retrieve("psikolog");
            $decodedData = json_decode($data, true);

            if (is_array($decodedData)) {
                foreach ($decodedData as $id => $psikolog) {
                    if (is_array($psikolog)) {
                        echo "<tr>
                                <td><img src='{$psikolog['profilePict']}' style='max-width: 100px; max-height: 100px;'></td>
                                <td>{$psikolog['name']}</td>
                                <td>{$psikolog['email']}</td>
                                <td>{$psikolog['phoneNum']}</td>
                                <td>{$psikolog['roles']}</td> 
                                <td>{$psikolog['officeLocation']}</td> 
                                <td>{$psikolog['profileDescription']}</td> 
                                <td><a href='edit.php?id=$id' class='btn btn-warning'>EDIT</a></td>
                                <td><a href='delete.php?id=$id' class='btn btn-danger'>DELETE</a></td>
                              </tr>";
                    } else {
                        // Handle the case where $psikolog is not an array (perhaps log an error)
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
