<?php
// Handle GET requests for quotes

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$author_id = isset($_GET['author_id']) ? (int)$_GET['author_id'] : null;
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$random = isset($_GET['random']) && $_GET['random'] === 'true' ? true : false;

// Validate author_id if provided
if ($author_id && !$author->exists($author_id)) {
    http_response_code(404);
    echo json_encode(['message' => 'author_id Not Found']);
    exit();
}

// Validate category_id if provided
if ($category_id && !$category->exists($category_id)) {
    http_response_code(404);
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}

if ($id) {
    // Get single quote by id
    $quote->id = $id;
    $result = $quote->read_single();
} else {
    // Get quotes with optional filters
    $result = $quote->read($author_id, $category_id, $random);
}

$quotes = $result->fetchAll(PDO::FETCH_ASSOC);

if ($quotes) {
    echo json_encode($quotes);
} else {
    http_response_code(404);
    echo json_encode(['message' => 'No Quotes Found']);
}
?>
