<?php
// Handle PUT requests for authors (update)

$data = json_decode(file_get_contents('php://input'), true);

// Check required fields
if (!isset($data['id']) || !isset($data['author']) || empty($data['author'])) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

// Set author properties
$author->id = (int)$data['id'];
$author->author = $data['author'];

// Check if author exists
if (!$author->exists($author->id)) {
    echo json_encode(['message' => 'author_id Not Found']);
    exit();
}

// Update author
if ($author->update()) {
    echo json_encode([
        'id' => $author->id,
        'author' => $author->author
    ]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error updating author']);
}
?>
