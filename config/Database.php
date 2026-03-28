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
                $this->conn = new PDO(getenv('DATABASE_URL'));
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
