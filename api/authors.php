<?php
header('Content-Type: application/json');
require_once '../db/config.php';
require_once '../classes/Author.php';

$method = $_SERVER['REQUEST_METHOD'];
$author = new Author($conn);

// Handle GET requests
if ($method === 'GET') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    $authors = $author->getAuthors($id);

    if ($id) {
        if (!empty($authors)) {
            echo json_encode($authors[0]);
        } else {
            echo json_encode(['message' => 'author_id Not Found']);
        }
    } elseif (!empty($authors)) {
        echo json_encode($authors);
    } else {
        echo json_encode(['message' => 'author_id Not Found']);
    }
}

// Handle POST requests
elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required parameters
    if (!isset($data['author']) || empty($data['author'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    $result = $author->createAuthor($data['author']);

    if ($result) {
        echo json_encode($result);
        http_response_code(201);
    } else {
        echo json_encode(['message' => 'Error creating author']);
        http_response_code(500);
    }
}

// Handle PUT requests
elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required parameters
    if (!isset($data['id']) || !isset($data['author']) || empty($data['author'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    $result = $author->updateAuthor($data['id'], $data['author']);

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'author_id Not Found']);
    }
}

// Handle DELETE requests
elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required id parameter
    if (!isset($data['id'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    // Check if author exists
    $authors = $author->getAuthors($data['id']);
    if (empty($authors)) {
        echo json_encode(['message' => 'author_id Not Found']);
        exit;
    }

    if ($author->deleteAuthor($data['id'])) {
        echo json_encode(['id' => $data['id']]);
    } else {
        echo json_encode(['message' => 'Error deleting author']);
        http_response_code(500);
    }
}
?>
