<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Get all quotes or filter by id, author_id, category_id
    public function getQuotes($id = null, $author_id = null, $category_id = null, $random = false) {
        $query = "SELECT q.id, q.quote, a.author, c.category
                  FROM " . $this->table . " q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id
                  WHERE 1=1";

        if ($id) {
            $query .= " AND q.id = :id";
        }
        if ($author_id) {
            $query .= " AND q.author_id = :author_id";
        }
        if ($category_id) {
            $query .= " AND q.category_id = :category_id";
        }

        if ($random) {
            $query .= " ORDER BY RANDOM() LIMIT 1";
        }

        $stmt = $this->conn->prepare($query);

        if ($id) {
            $stmt->bindParam(':id', $id);
        }
        if ($author_id) {
            $stmt->bindParam(':author_id', $author_id);
        }
        if ($category_id) {
            $stmt->bindParam(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new quote
    public function createQuote($quote, $author_id, $category_id) {
        $query = "INSERT INTO " . $this->table . " (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $quote);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':category_id', $category_id);

        if ($stmt->execute()) {
            return [
                'id' => $this->conn->lastInsertId(),
                'quote' => $quote,
                'author_id' => $author_id,
                'category_id' => $category_id
            ];
        }
        return false;
    }

    // Update a quote
    public function updateQuote($id, $quote, $author_id, $category_id) {
        $query = "UPDATE " . $this->table . "
                  SET quote = :quote, author_id = :author_id, category_id = :category_id
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':quote', $quote);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':category_id', $category_id);

        if ($stmt->execute()) {
            return [
                'id' => $id,
                'quote' => $quote,
                'author_id' => $author_id,
                'category_id' => $category_id
            ];
        }
        return false;
    }

    // Delete a quote
    public function deleteQuote($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
