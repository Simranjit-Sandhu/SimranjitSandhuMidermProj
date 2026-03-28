<?php
class Author {
    private $conn;
    private $table = 'authors';

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all authors or specific author by id
    public function getAuthors($id = null) {
        $query = "SELECT id, author FROM " . $this->table;

        if ($id) {
            $query .= " WHERE id = :id";
        }

        $stmt = $this->conn->prepare($query);

        if ($id) {
            $stmt->bindParam(':id', $id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new author
    public function createAuthor($author) {
        $query = "INSERT INTO " . $this->table . " (author) VALUES (:author)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author', $author);

        if ($stmt->execute()) {
            return [
                'id' => $this->conn->lastInsertId(),
                'author' => $author
            ];
        }
        return false;
    }

    // Update an author
    public function updateAuthor($id, $author) {
        $query = "UPDATE " . $this->table . " SET author = :author WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':author', $author);

        if ($stmt->execute()) {
            return [
                'id' => $id,
                'author' => $author
            ];
        }
        return false;
    }

    // Delete an author
    public function deleteAuthor($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Check if author exists
    public function authorExists($id) {
        $query = "SELECT id FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
