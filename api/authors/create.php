<?php
// Handle POST requests for authors (create)

$data = json_decode(file_get_contents('php://input'), true);

// Check if author field is present
if (!isset($data['author']) || empty($data['author'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

// Set author property
$author->author = $data['author'];

// Create author
$new_id = $author->create();

if ($new_id) {
    http_response_code(201);
    echo json_encode([
        'id' => $new_id,
        'author' => $author->author
    ]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error creating author']);
}
?>
