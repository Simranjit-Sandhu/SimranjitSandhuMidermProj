<?php
header('Content-Type: application/json');

require_once __DIR__ . '/config/Database.php';

$expectedToken = getenv('DB_INIT_TOKEN');
$providedToken = isset($_GET['token']) ? $_GET['token'] : '';

if (empty($expectedToken) || $providedToken !== $expectedToken) {
    http_response_code(403);
    echo json_encode([
        'message' => 'Forbidden. Set DB_INIT_TOKEN and pass ?token=...'
    ]);
    exit;
}

$schemaPath = __DIR__ . '/db/schema.sql';
$seedPath = __DIR__ . '/db/sample_data.sql';

if (!file_exists($schemaPath) || !file_exists($seedPath)) {
    http_response_code(500);
    echo json_encode(['message' => 'Schema or seed file not found.']);
    exit;
}

try {
    $database = new Database();
    $conn = $database->connect();

    $schemaSql = file_get_contents($schemaPath);
    $seedSql = file_get_contents($seedPath);

    $conn->beginTransaction();

    // Always ensure tables exist.
    $conn->exec($schemaSql);

    // Seed only when authors table has no rows to avoid duplicates.
    $countStmt = $conn->query('SELECT COUNT(*) FROM authors');
    $authorCount = (int) $countStmt->fetchColumn();

    if ($authorCount === 0) {
        $conn->exec($seedSql);
        $seedMessage = 'Seed data inserted.';
    } else {
        $seedMessage = 'Seed skipped (data already exists).';
    }

    $conn->commit();

    echo json_encode([
        'message' => 'Database initialized successfully.',
        'seed' => $seedMessage
    ]);
} catch (Throwable $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'message' => 'Database initialization failed: ' . $e->getMessage()
    ]);
}
