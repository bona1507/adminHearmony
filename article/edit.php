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
$retrieve = $db->retrieve("article/$id");
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
    <title>Edit Article - Hearmony Article Manager</title>
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
    <h2 class="mb-4">Edit Article</h2>
    <form method="post" action="../controller/action_edit.php" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="title" class="col-sm-3 col-form-label">Title:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $data['title']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="thumbnail" class="col-sm-3 col-form-label">Thumbnail:</label>
            <div class="col-sm-9">
                <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
            </div>
        </div>
        <div class="form-group row">
            <label for="content" class="col-md-3 col-form-label">Content:</label>
            <div class="col-md-9">
                <input id="content" type="hidden" name="content" rows="5" value="<?php echo $contentString?>">
                <trix-editor input="content"></trix-editor>
            </div>
        </div>
        <div class="form-group row">
            <label for="category" class="col-sm-3 col-form-label">Category:</label>
            <div class="col-sm-9">
                <select class="form-control" id="category" name="category">
                    <option value="Sexual Edu" <?php echo ($data['category'] === 'Sexual Edu') ? 'selected' : ''; ?>>Sexual Edu</option>
                    <option value="Finance" <?php echo ($data['category'] === 'Finance') ? 'selected' : ''; ?>>Finance</option>
                    <option value="Communication" <?php echo ($data['category'] === 'Communication') ? 'selected' : ''; ?>>Communication</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="editor" class="col-sm-3 col-form-label">Editor:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="editor" name="editor" value="<?php echo $data['editor']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="author" class="col-sm-3 col-form-label">Author:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $data['author']?>">
            </div>
        </div>
        <!-- End of fields -->
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <input type="hidden" name="id" value="<?php echo $id?>">
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
