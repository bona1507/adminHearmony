<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:/../index.php");
    exit();
}
include("../db/config.php");
include("../db/firebaseRDB.php");
require __DIR__.'/../vendor/autoload.php';
use Kreait\Firebase\Factory;

$db = new firebaseRDB($databaseURL);
$id = $_GET['id'];


if ($id != "") {
    $retrieve = $db->retrieve("article/$id");
    $data = json_decode($retrieve, true);

    if ($data) {
        // Delete the article data from the database
        $delete = $db->delete("article", $id);

        // Initialize Firebase Storage
        $factory = (new Factory)->withServiceAccount(__DIR__.'/../res/hackfest-ef21a-firebase-adminsdk-gs1gd-fbc2c04471.json');
        $storage = $factory->createStorage();

        // Delete the corresponding image file from Firebase Storage
        $storageBucket = $storage->getBucket();
        $storageBucket->object('thumbnails/' . 'psikolog' . $id . 'jpg');

        echo '<script>alert("Data delete successfully."); window.location.href = "../article/view.php";</script>';
    } else {
        echo '<script>alert("Article not found."); window.location.href = "../article/view.php";</script>';
    }
} else {
    echo '<script>alert("Invalid article id."); window.location.href = "../article/view.php";</script>';;
}
?>
