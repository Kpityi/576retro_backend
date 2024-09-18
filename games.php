<?php

// load necessary file
require_once "./middleware.php";
require_once "./db.php";


$sql = "SELECT * 
        FROM `games` 
        ORDER BY `release_year`";

$result = $conn->query($sql);

$games = array();
while($row = $result->fetch_assoc()) {
    $games[] = $row;
}

//Close connection
$conn->close();

//Send result
echo json_encode($games);
?>