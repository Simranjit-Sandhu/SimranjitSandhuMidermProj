<?php
header('Content-Type: application/json');
require_once '../db/config.php';
require_once '../classes/Category.php';

$method = $_SERVER['REQUEST_METHOD'];
$category = new Category($conn);

// Handle GET requests
if ($method === 'GET') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

    $categories = $category->getCategories($id);

    if ($id) {
        if (!empty($categories)) {
            echo json_encode($categories[0]);
        } else {
            echo json_encode(['message' => 'category_id Not Found']);
        }
    } elseif (!empty($categories)) {
        echo json_encode($categories);
    } else {
        echo json_encode(['message' => 'category_id Not Found']);
    }
}

// Handle POST requests
elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required parameters
    if (!isset($data['category']) || empty($data['category'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    $result = $category->createCategory($data['category']);

    if ($result) {
        echo json_encode($result);
        http_response_code(201);
    } else {
        echo json_encode(['message' => 'Error creating category']);
        http_response_code(500);
    }
}

// Handle PUT requests
elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required parameters
    if (!isset($data['id']) || !isset($data['category']) || empty($data['category'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit;
    }

    $result = $category->updateCategory($data['id'], $data['category']);

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'category_id Not Found']);
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

    // Check if category exists
    $categories = $category->getCategories($data['id']);
    if (empty($categories)) {
        echo json_encode(['message' => 'category_id Not Found']);
        exit;
    }

    if ($category->deleteCategory($data['id'])) {
        echo json_encode(['id' => $data['id']]);
    } else {
        echo json_encode(['message' => 'Error deleting category']);
        http_response_code(500);
    }
}
?>
