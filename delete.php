<?php
include 'config.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM prescriptions WHERE id=$id");

header("Location: prescription.php");
?>