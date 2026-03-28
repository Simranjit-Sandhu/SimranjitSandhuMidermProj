<?php
/**
 * Database Class
 * PDO connection to Postgres database
 * Supports both local development and Render.com deployment
 */
class Database
{
    // For local development with PostgreSQL
    private $host = 'localhost';
    private $port = '5432';
    private $db_name = 'quotesdb';
    private $db_user = 'postgres';
    private $db_pass = '';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            // For Render.com deployment, use DATABASE_URL environment variable
            if (!empty(getenv('DATABASE_URL'))) {
                $databaseUrl = getenv('DATABASE_URL');
                $parts = parse_url($databaseUrl);

                if ($parts !== false && isset($parts['scheme']) && isset($parts['host']) && isset($parts['path'])) {
                    // Render provides postgres://... URLs; convert to PDO pgsql DSN.
                    $host = $parts['host'];
                    $port = isset($parts['port']) ? $parts['port'] : '5432';
                    $dbName = ltrim($parts['path'], '/');
                    $user = isset($parts['user']) ? $parts['user'] : null;
                    $pass = isset($parts['pass']) ? $parts['pass'] : null;

                    $dsn = 'pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbName;
                    $this->conn = new PDO($dsn, $user, $pass);
                } else {
                    // Fallback for any already-formatted DSN values.
                    $this->conn = new PDO($databaseUrl);
                }
            } else {
                // For local development
                $this->conn = new PDO(
                    'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name,
                    $this->db_user,
                    $this->db_pass
                );
            }
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(json_encode(['message' => 'Database connection failed: ' . $e->getMessage()]));
        }

        return $this->conn;
    }
}
?>
