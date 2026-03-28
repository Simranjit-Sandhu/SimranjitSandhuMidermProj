<?php
header('Content-Type: application/json');
require_once '../db/config.php';
require_once '../classes/Quote.php';
require_once '../classes/Author.php';
require_once '../classes/Category.php';

$method = $_SERVER['REQUEST_METHOD'];
$quote = new Quote($conn);

// Handle GET requests
if ($method === 'GET') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    $author_id = isset($_GET['author_id']) ? (int)$_GET['author_id'] : null;
    $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
    $random = isset($_GET['random']) && $_GET['random'] === 'true' ? true : false;

    if ($author_id || $category_id) {
        // Check if author_id exists
        if ($author_id) {
            $author = new Author($conn);
            if (!$author->authorExists($author_id)) {
                echo json_encode(['message' => 'author_id Not Found']);
                http_response_code(404);
                exit;
            }
        }

        // Check if category_id exists
        if ($category_id) {
            $category = new Category($conn);
            if (!$category->categoryExists($category_id)) {
                echo json_encode(['message' => 'category_id Not Found']);
                http_response_code(404);
                exit;
            }
        }
    }

    $quotes = $quote->getQuotes($id, $author_id, $category_id, $random);

    if (!empty($quotes)) {
        echo json_encode($quotes);
    } else {
        echo json_encode(['message' => 'No Quotes Found']);
        http_response_code(404);
    }
}

// Handle POST requests
elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required parameters
    if (!isset($data['quote']) || !isset($data['author_id']) || !isset($data['category_id'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        http_response_code(400);
        exit;
    }

    // Check if author_id exists
    $author = new Author($conn);
    if (!$author->authorExists($data['author_id'])) {
        echo json_encode(['message' => 'author_id Not Found']);
        http_response_code(404);
        exit;
    }

    // Check if category_id exists
    $category = new Category($conn);
    if (!$category->categoryExists($data['category_id'])) {
        echo json_encode(['message' => 'category_id Not Found']);
        http_response_code(404);
        exit;
    }

    $result = $quote->createQuote($data['quote'], $data['author_id'], $data['category_id']);

    if ($result) {
        echo json_encode($result);
        http_response_code(201);
    } else {
        echo json_encode(['message' => 'Error creating quote']);
        http_response_code(500);
    }
}

// Handle PUT requests
elseif ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required parameters
    if (!isset($data['id']) || !isset($data['quote']) || !isset($data['author_id']) || !isset($data['category_id'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        http_response_code(400);
        exit;
    }

    // Check if author_id exists
    $author = new Author($conn);
    if (!$author->authorExists($data['author_id'])) {
        echo json_encode(['message' => 'author_id Not Found']);
        http_response_code(404);
        exit;
    }

    // Check if category_id exists
    $category = new Category($conn);
    if (!$category->categoryExists($data['category_id'])) {
        echo json_encode(['message' => 'category_id Not Found']);
        http_response_code(404);
        exit;
    }

    $result = $quote->updateQuote($data['id'], $data['quote'], $data['author_id'], $data['category_id']);

    if ($result) {
        echo json_encode($result);
    } else {
        echo json_encode(['message' => 'No Quotes Found']);
        http_response_code(404);
    }
}

// Handle DELETE requests
elseif ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check for required id parameter
    if (!isset($data['id'])) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        http_response_code(400);
        exit;
    }

    // Check if quote exists
    $quotes = $quote->getQuotes($data['id']);
    if (empty($quotes)) {
        echo json_encode(['message' => 'No Quotes Found']);
        http_response_code(404);
        exit;
    }

    if ($quote->deleteQuote($data['id'])) {
        echo json_encode(['id' => $data['id']]);
    } else {
        echo json_encode(['message' => 'Error deleting quote']);
        http_response_code(500);
    }
}
?>
