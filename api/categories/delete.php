<?php
// Handle DELETE requests for categories (delete)

$data = json_decode(file_get_contents('php://input'), true);

// Check if id is present
if (!isset($data['id'])) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$category->id = (int)$data['id'];

// Check if category exists
if (!$category->exists($category->id)) {
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}

// Delete category
if ($category->delete()) {
    echo json_encode(['id' => $category->id]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error deleting category']);
}
?>
