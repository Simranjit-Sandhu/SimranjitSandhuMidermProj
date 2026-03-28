<?php
// CORS Headers - REQUIRED for automated tests to work!
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Database and Models
require_once '../../config/Database.php';
require_once '../../models/Quote.php';
require_once '../../models/Author.php';
require_once '../../models/Category.php';

// Initialize database connection
$database = new Database();
$db = $database->connect();

// Create instances
$quote = new Quote($db);
$author = new Author($db);
$category = new Category($db);

// Route based on HTTP method
if ($method === 'GET') {
    require_once 'read.php';
} elseif ($method === 'POST') {
    require_once 'create.php';
} elseif ($method === 'PUT') {
    require_once 'update.php';
} elseif ($method === 'DELETE') {
    require_once 'delete.php';
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}
?>
