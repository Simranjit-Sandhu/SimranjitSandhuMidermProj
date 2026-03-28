<?php
// Handle GET requests for categories

if (isset($_GET['id'])) {
    // Get single category
    $category->id = (int)$_GET['id'];
    $result = $category->read_single();
    $categories = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($categories) {
        echo json_encode($categories);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'category_id Not Found']);
    }
} else {
    // Get all categories
    $result = $category->read();
    $categories = $result->fetchAll(PDO::FETCH_ASSOC);

    if ($categories) {
        echo json_encode($categories);
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'category_id Not Found']);
    }
}
?>
