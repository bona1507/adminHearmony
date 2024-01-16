<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Goal Recommendation - Hearmony Article Manager</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Add Recommendation</h2>
    <form method="post" action="../controller/recommendation_add.php" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="title" class="col-sm-3 col-form-label">Title:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="title" name="title">
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
                <input type="text" class="form-control-file" id="price" name="price">
            </div>
        </div>
        <div class="form-group row">
            <label for="category" class="col-sm-3 col-form-label">Category:</label>
            <div class="col-sm-9">
                <select class="form-control" id="category" name="category">
                    <option value="Residence">Residence</option>
                    <option value="Vacation">Vacation</option>
                    <option value="Laptop">Laptop</option>
                    <option value="Mobile Device">Mobile Device</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="subcategories" class="col-sm-3 col-form-label">Subcategories:</label>
            <div class="col-sm-9">
                <select class="form-control" id="subcategories" name="subcategories"></select>
            </div>
        </div>
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

<script>
    $(document).ready(function() {
        // Define subcategories for each category
        var subcategories = {
            Residence: ["House", "Apartment"],
            Vacation: ["Transportation", "Hotel", "Villa", "Place"],
            Laptop: ["General", "Gaming", "Notebook"],
            "Mobile Device": ["Smartphone", "Tablet", "Smartwatch"]
        };

        // Function to update subcategories dropdown based on selected category
        function updateSubcategories() {
            var selectedCategory = $("#category").val();
            var subcategoryDropdown = $("#subcategories");
            subcategoryDropdown.empty();

            if (selectedCategory in subcategories) {
                var subcategoryOptions = subcategories[selectedCategory];
                $.each(subcategoryOptions, function(index, value) {
                    subcategoryDropdown.append($("<option>").text(value).val(value));
                });
            }
        }

        // Initial update when the page loads
        updateSubcategories();

        // Event listener for changes in the category dropdown
        $("#category").change(function() {
            updateSubcategories();
        });
    });
</script>

</body>
</html>
