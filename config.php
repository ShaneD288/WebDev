<?php
$conn = mysqli_connect("localhost", "root", "", "pharmacy_db");

if(!$conn){
    die("Connection failed");
}
