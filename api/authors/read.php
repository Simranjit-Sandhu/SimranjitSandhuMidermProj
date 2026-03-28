<?php
// Handle GET requests for authors

if (isset($_GET['id'])) {
    // Get single author
    $author->id = (int)$_GET['id'];
    $result = $author->read_single();
    $authors = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($authors) {
        echo json_encode($authors);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'author_id Not Found']);
    }
} else {
    // Get all authors
    $result = $author->read();
    $authors = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($authors) {
        echo json_encode($authors);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'author_id Not Found']);
    }
}
?>
