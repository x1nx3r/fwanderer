<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "127.0.0.1";
$username = "udin";
$password = "5kxlrsejJMeOVuR*";
$dbname = "players";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SERVER["CONTENT_TYPE"]) && strpos($_SERVER["CONTENT_TYPE"], "application/json") !== false) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (isset($data['name']) && isset($data['score'])) {
            $name = $conn->real_escape_string($data['name']);
            $score = $conn->real_escape_string($data['score']);

            $sql = "INSERT INTO playerlist (name, score) VALUES ('$name', '$score')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Invalid Content-Type. Expected application/json";
    }
}

$conn->close();