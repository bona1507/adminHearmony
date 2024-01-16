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
    $retrieve = $db->retrieve("psikolog/$id");
    $data = json_decode($retrieve, true);

    if ($data) {
        // Delete the article data from the database
        $delete = $db->delete("psikolog", $id);

        // Initialize Firebase Storage
        $factory = (new Factory)->withServiceAccount(__DIR__.'/../res/hackfest-ef21a-firebase-adminsdk-gs1gd-fbc2c04471.json');
        $storage = $factory->createStorage();

        // Delete the corresponding image file from Firebase Storage
        $storageBucket = $storage->getBucket();
        $storageBucket->object('psikolog/' . 'psikolog' . $id);

        echo '<script>alert("Data delete successfully."); window.location.href = "../psikolog/view.php";</script>';
    } else {
        echo '<script>alert("Account not found."); window.location.href = "../psikolog/view.php";</script>';
    }
} else {
    echo '<script>alert("Invalid psikolog id."); window.location.href = "../psikolog/view.php";</script>';;
}
?>
