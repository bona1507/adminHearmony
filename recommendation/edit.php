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
$retrieve = $db->retrieve("recommendation/$id");
$data = json_decode($retrieve, true);
// Check if data is available
if (!$data) {
    echo "Error: Data not found";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Goal Recommendation - Hearmony Admin Manager</title>
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
    <form method="post" action="../controller/recommendation_edit.php" enctype="multipart/form-data">
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
            <label for="price" class="col-sm-3 col-form-label">Price:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control-file" id="price" name="price" value="<?php echo $data['price']?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="category" class="col-sm-3 col-form-label">Category:</label>
            <div class="col-sm-9">
                <select class="form-control" id="category" name="category">
                    <option value="Residence" <?php echo ($data['category'] === 'Residence') ? 'selected' : ''; ?>>Residence</option>
                    <option value="Vacation" <?php echo ($data['category'] === 'Vacation') ? 'selected' : ''; ?>>Vacation</option>               
                    <option value="Laptop" <?php echo ($data['category'] === 'Laptop') ? 'selected' : ''; ?>>Laptop</option>
                    <option value="Mobile Device" <?php echo ($data['category'] === 'Mobile Device') ? 'selected' : ''; ?>>Mobile Device</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="subcategory" class="col-sm-3 col-form-label">Subcategory:</label>
            <div class="col-sm-9">
                <select class="form-control" id="subcategory" name="subcategory">
                    <?php
                        $subcategories = [
                            'Residence' => ['House', 'Apartment'],
                            'Vacation' => ['Transportation', 'Hotel', 'Villa', 'Place'],
                            'Laptop' => ['General', 'Gaming', 'Notebook'],
                            'Mobile Device' => ['Smartphone', 'Tablet', 'Smartwatch']
                        ];

                        // Get the selected category
                        $selectedCategory = $data['category'];

                        // Populate subcategories dropdown based on the selected category
                        foreach ($subcategories[$selectedCategory] as $subcategory) {
                            $selected = ($data['subcategory'] === $subcategory) ? 'selected' : '';
                            echo "<option value='$subcategory' $selected>$subcategory</option>";
                        }
                    ?>
                </select>
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
