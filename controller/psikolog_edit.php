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
    $id = $_GET['id'];

    // Fetch existing data from Firebase Realtime Database
    $retrieve = $db->retrieve("psikolog/$id");
    $data = json_decode($retrieve, true);

    // Check if the thumbnail file input is empty
    if (empty($_FILES['profilePict']['name'])) {
        echo '<script>alert("Please provide a new thumbnail."); window.location.href = "../psikolog/edit.php?id=' . $id . '";</script>';
        exit();
    }

    // Initialize Firebase Storage
    $factory = (new Factory)->withServiceAccount(__DIR__.'/../res/hackfest-ef21a-firebase-adminsdk-gs1gd-fbc2c04471.json');
    $storage = $factory->createStorage();

    // Handle file upload to Firebase Storage
    $storageBucket = $storage->getBucket();
    $storageBucket->object('psikolog/' . 'profilepict' . $id . '.jpg')->delete();

    // Upload the new file to Firebase Storage and rename it based on the article title
    $file = $_FILES['profilePict'];
    $newFileName = 'psikolog/profilepict' . $id . '.jpg';
    $object = $storageBucket->upload(file_get_contents($file['tmp_name']), ['name' => $newFileName]);

    // Get the public URL of the uploaded file
    $thumbnailURL = $object->signedUrl(new \DateTime('2030-12-31'));

    // Update data in Firebase Realtime Database
    $update = $db->update("psikolog", $id, [
        "name"              => $_POST['name'],
        "profilePict"       => $thumbnailURL,
        "email"             => $_POST['email'],
        "phoneNum"          => $_POST['phoneNum'],
        "roles"             => $_POST['roles'],
        "officeLocation"    => $_POST['officeLocation'],
        "profileDescription"=> $_POST['profileDescription']
    ]);

    echo '<script>alert("Data updated successfully."); window.location.href = "../psikolog/view.php";</script>';
    exit();
} else {
    echo '<script>alert("Invalid request method."); window.location.href = "../psikolog/edit.php?id=' . $id . '";</script>';
    exit();
}
?>
