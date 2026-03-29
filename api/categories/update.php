<?php
// Handle PUT requests for categories (update)

$data = json_decode(file_get_contents('php://input'), true);

// Check required fields
if (!isset($data['id']) || !isset($data['category']) || empty($data['category'])) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

// Set category properties
$category->id = (int)$data['id'];
$category->category = $data['category'];

// Check if category exists
if (!$category->exists($category->id)) {
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}

// Update category
if ($category->update()) {
    echo json_encode([
        'id' => $category->id,
        'category' => $category->category
    ]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error updating category']);
}
?>
