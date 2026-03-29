<?php
// Handle GET requests for authors

if (isset($_GET['id'])) {
    // Get single author
    $author->id = (int)$_GET['id'];
    $result = $author->read_single();
    $author_item = $result->fetch(PDO::FETCH_ASSOC);

    if ($author_item) {
        echo json_encode($author_item);
    } else {
        echo json_encode(['message' => 'author_id Not Found']);
    }
} else {
    // Get all authors
    $result = $author->read();
    $authors = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($authors) {
        echo json_encode($authors);
    } else {
        echo json_encode(['message' => 'author_id Not Found']);
    }
}
?>
