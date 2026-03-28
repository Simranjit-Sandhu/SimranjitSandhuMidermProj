<?php
// Handle DELETE requests for authors (delete)

$data = json_decode(file_get_contents('php://input'), true);

// Check if id is present
if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$author->id = (int)$data['id'];

// Check if author exists
if (!$author->exists($author->id)) {
    http_response_code(404);
    echo json_encode(['message' => 'author_id Not Found']);
    exit();
}

// Delete author
if ($author->delete()) {
    echo json_encode(['id' => $author->id]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error deleting author']);
}
?>
