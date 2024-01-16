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
    $file = $_FILES['profilePict'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Check if the file extension is JPG
    if ($fileExtension !== 'jpg') {
        echo '<script>alert("Please upload a JPG file."); window.location.href = "../psikolog/add.php";</script>';
        exit();
    }

    $newPsikologRef = $database->getReference("psikolog")->push();
    $newPsikologKey = $newPsikologRef->getKey();

    $newFileName = 'psikolog' . $newPsikologKey . '.jpg';
    $fileTmpName = $file['tmp_name'];

    // Upload the file to Firebase Storage
    $storageBucket = $storage->getBucket();
    $object = $storageBucket->upload(file_get_contents($fileTmpName), ['name' => 'psikolog/'.$newFileName]);

    // Get the public URL of the uploaded file
    $thumbnailURL = $object->signedUrl(new \DateTime('2030-12-31'));
    date_default_timezone_set('Asia/Bangkok');
    $currentTimestamp = date('Y-m-d H:i:s');

    $insert = $newPsikologRef->set([
        "id"                => $newPsikologKey,
        "name"              => $_POST['name'],
        "profilePict"       => $thumbnailURL,
        "email"             => $_POST['email'],
        "phoneNum"          => $_POST['phoneNum'],
        "roles"             => $_POST['roles'],
        "officeLocation"    => $_POST['officeLocation'],
        "profileDescription"=> $_POST['profileDescription']
    ]);

    echo '<script>alert("Data update successfully."); window.location.href = "../psikolog/view.php";</script>';
    exit();
} else {
    echo '<script>alert("Invalid request method."); window.location.href = "../psikolog/add.php?id=' . $id . '";</script>';
    exit();
}
?>