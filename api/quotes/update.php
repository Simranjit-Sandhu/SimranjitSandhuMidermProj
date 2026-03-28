<?php
// Handle PUT requests for quotes (update)

$data = json_decode(file_get_contents('php://input'), true);

// Check required fields
if (!isset($data['id']) || !isset($data['quote']) || !isset($data['author_id']) || !isset($data['category_id'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

// Check if quote exists
if (!$quote->exists($data['id'])) {
    http_response_code(404);
    echo json_encode(['message' => 'No Quotes Found']);
    exit();
}

// Validate author_id exists
if (!$author->exists($data['author_id'])) {
    http_response_code(404);
    echo json_encode(['message' => 'author_id Not Found']);
    exit();
}

// Validate category_id exists
if (!$category->exists($data['category_id'])) {
    http_response_code(404);
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}

// Set quote properties
$quote->id = (int)$data['id'];
$quote->quote = $data['quote'];
$quote->author_id = (int)$data['author_id'];
$quote->category_id = (int)$data['category_id'];

// Update quote
if ($quote->update()) {
    echo json_encode([
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id
    ]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error updating quote']);
}
?>
