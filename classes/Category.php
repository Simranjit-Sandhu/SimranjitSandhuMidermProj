<?php
class Category {
    private $conn;
    private $table = 'categories';

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all categories or specific category by id
    public function getCategories($id = null) {
        $query = "SELECT id, category FROM " . $this->table;

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

    // Create a new category
    public function createCategory($category) {
        $query = "INSERT INTO " . $this->table . " (category) VALUES (:category)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category', $category);

        if ($stmt->execute()) {
            return [
                'id' => $this->conn->lastInsertId(),
                'category' => $category
            ];
        }
        return false;
    }

    // Update a category
    public function updateCategory($id, $category) {
        $query = "UPDATE " . $this->table . " SET category = :category WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':category', $category);

        if ($stmt->execute()) {
            return [
                'id' => $id,
                'category' => $category
            ];
        }
        return false;
    }

    // Delete a category
    public function deleteCategory($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Check if category exists
    public function categoryExists($id) {
        $query = "SELECT id FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
