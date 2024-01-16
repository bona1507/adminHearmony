<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:/../index.php");
    exit();
}
include("../db/config.php");
include("../db/firebaseRDB.php");
require __DIR__ . '/../vendor/autoload.php';
use Kreait\Firebase\Factory;

$db = new firebaseRDB($databaseURL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize Firebase Storage
    $factory = (new Factory)->withServiceAccount(__DIR__.'/../res/hackfest-ef21a-firebase-adminsdk-gs1gd-fbc2c04471.json');
    $storage = $factory->createStorage();
    
    // Initialize Firebase Realtime Database
    $firebase = (new Factory)
            ->withServiceAccount(__DIR__.'/../res/hackfest-ef21a-firebase-adminsdk-gs1gd-fbc2c04471.json')
            ->withDatabaseUri('https://hackfest-ef21a-default-rtdb.asia-southeast1.firebasedatabase.app/');
    $database = $firebase->createDatabase();

    // Handle file upload to Firebase Storage
    $file = $_FILES['thumbnail'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Check if the file extension is JPG
    if ($fileExtension !== 'jpg') {
        echo '<script>alert("Please upload a JPG file."); window.location.href = "../recommendation/add.php";</script>';
        exit();
    }

    $newRecommendationRef = $database->getReference("recommendation")->push();
    $newRecommendationKey = $newRecommendationRef->getKey();

    $newFileName = 'recommendation' . $newRecommendationKey . '.jpg';
    $fileTmpName = $file['tmp_name'];

    // Upload the file to Firebase Storage
    $storageBucket = $storage->getBucket();
    $object = $storageBucket->upload(file_get_contents($fileTmpName), ['name' => 'recommendation/'.$newFileName]);

    // Get the public URL of the uploaded file
    $thumbnailURL = $object->signedUrl(new \DateTime('2030-12-31'));
    date_default_timezone_set('Asia/Bangkok');
    $currentTimestamp = date('Y-m-d H:i:s');

    $insert = $newRecommendationRef->set([
        "id"        => $newRecommendationKey,
        "title"     => $_POST['title'],
        "thumbnail" => $thumbnailURL,
        "category"  => $_POST['category'],
        "subcategory"  => $_POST['subcategories'],
        "price"  => $_POST['price'],
        "timestamp" => $currentTimestamp
    ]);

    echo '<script>alert("Data update successfully."); window.location.href = "../recommendation/view.php";</script>';
    exit();
} else {
    echo '<script>alert("Invalid request method."); window.location.href = "../recommendation/add.php?id=' . $id . '";</script>';
    exit();
}
?>
