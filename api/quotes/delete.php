<?php
// Handle DELETE requests for quotes (delete)

$data = json_decode(file_get_contents('php://input'), true);

// Check if id is present
if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$quote->id = (int)$data['id'];

// Check if quote exists
if (!$quote->exists($quote->id)) {
    http_response_code(404);
    echo json_encode(['message' => 'No Quotes Found']);
    exit();
}

// Delete quote
if ($quote->delete()) {
    echo json_encode(['id' => $quote->id]);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Error deleting quote']);
}
?>
