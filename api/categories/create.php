<?php
// Handle POST requests for categories (create)

$data = json_decode(file_get_contents('php://input'), true);

// Check if category field is present
if (!isset($data['category']) || empty($data['category'])) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

// Set category property
$category->category = $data['category'];

// Create category
$new_id = $category->create();

if ($new_id) {
    http_response_code(201);
    echo json_encode([
        'id' => $new_id,
        'category' => $category->category
    ]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error creating category']);
}
?>
