<?php

// load necessary file
require_once "./middleware.php";
require_once "./db.php";

$game_id = $_GET["game_id"];
$data=[];
$data=json_decode(file_get_contents('php://input'), true);

$name = $data["name"];
$comment = $data["comment"];

// Prepare statement to avoid SQL injection
$stmt = $conn->prepare("INSERT INTO comments (user_name, comment, game_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $name, $comment, $game_id);

// Execute the statement
$success = $stmt->execute();

// Close the connection
$stmt->close();
$conn->close();

// Return a JSON response
echo json_encode(["success" => $success]);

