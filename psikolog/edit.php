<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:/../index.php");
    exit();
}
include("../db/config.php");
include("../db/firebaseRDB.php");
$db = new firebaseRDB($databaseURL);
$id = $_GET['id'];
// Fetch data from Firebase
$retrieve = $db->retrieve("psikolog/$id");
$data = json_decode($retrieve, true);
// Check if data is available
if (!$data) {
    echo "Error: Data not found";
    exit;
}
$contentString = htmlspecialchars($data['content']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Psikolog Account - Hearmony Admin Manager</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Edit Account</h2>
    <form method="post" action="../controller/psikolog_edit.php" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Name:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['name']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="profilePict" class="col-sm-3 col-form-label">Profile Picture:</label>
            <div class="col-sm-9">
                <input type="file" class="form-control-file" id="profilePict" name="profilePict">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-file" id="email" name="email" value="<?php echo $data['email']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="phoneNum" class="col-sm-3 col-form-label">Phone Number:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="phoneNum" name="phoneNum" value="<?php echo $data['phoneNum']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="officeName" class="col-sm-3 col-form-label">Office Name:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="officeName" name="officeName">
            </div>
        </div>
        <div class="form-group row">
            <label for="officeLocation" class="col-sm-3 col-form-label">Office Location:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="officeLocation" name="officeLocation" value="<?php echo $data['officeLocation']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="profileDescription" class="col-sm-3 col-form-label">Profile Description:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="profileDescription" name="profileDescription" value="<?php echo $data['profileDescription']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="roles" class="col-sm-3 col-form-label">Roles:</label>
            <div class="col-sm-9">
                <select class="form-control" id="roles" name="roles">
                    <option value="Finance Consultant" <?php echo ($data['roles'] === 'Finance Consultant') ? 'selected' : ''; ?>>Finance Consultant</option>
                    <option value="Obgyn" <?php echo ($data['roles'] === 'Obgyn') ? 'selected' : ''; ?>>Obgyn</option>
                    <option value="General Psikolog" <?php echo ($data['roles'] === 'General Psikolog') ? 'selected' : ''; ?>>General Psikolog</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="treatment" class="col-sm-3 col-form-label">Treatment:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="treatment" name="treatment">
            </div>
        </div>
        <div class="form-group row">
            <label for="experience" class="col-sm-3 col-form-label">Experience:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="experience" name="experience">
            </div>
        </div>
        <div class="form-group row">
            <label for="education" class="col-sm-3 col-form-label">Education:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="education" name="education">
            </div>
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn btn-primary">SAVE</button>
            </div>
        </div>
    </form>
</div>

<!-- Bootstrap JS and Popper.js (optional) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
