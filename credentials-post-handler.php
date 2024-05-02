<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

function loadEnvironmentVariables($filePath) {
    if (!is_file($filePath)) {
        throw new Exception('Environment file not found.');
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER)) {
            $_SERVER[$name] = $value;
        }
    }
}

loadEnvironmentVariables(__DIR__ . '/credentials.env');

$servername = $_SERVER['DB_HOST'];
$username = $_SERVER['DB_USER'];
$password = $_SERVER['DB_PASSWORD'];
$dbname = $_SERVER['DB_NAME'];


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