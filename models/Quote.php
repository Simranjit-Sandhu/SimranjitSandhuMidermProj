<?php
/**
 * Quote Model Class
 */
class Quote
{
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get all quotes with optional filters and joins
    public function read($author_id = null, $category_id = null, $random = false)
    {
        $query = 'SELECT q.id, q.quote, a.author, c.category 
                  FROM ' . $this->table . ' q 
                  JOIN authors a ON q.author_id = a.id 
                  JOIN categories c ON q.category_id = c.id 
                  WHERE 1=1';

        if ($author_id) {
            $query .= ' AND q.author_id = :author_id';
        }
        if ($category_id) {
            $query .= ' AND q.category_id = :category_id';
        }
        if ($random) {
            $query .= ' ORDER BY RANDOM() LIMIT 1';
        }

        $stmt = $this->conn->prepare($query);

        if ($author_id) {
            $stmt->bindParam(':author_id', $author_id);
        }
        if ($category_id) {
            $stmt->bindParam(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt;
    }

    // Get single quote by id
    public function read_single()
    {
        $query = 'SELECT q.id, q.quote, a.author, c.category 
                  FROM ' . $this->table . ' q 
                  JOIN authors a ON q.author_id = a.id 
                  JOIN categories c ON q.category_id = c.id 
                  WHERE q.id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Create quote
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) 
                  VALUES (:quote, :author_id, :category_id)';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Update quote
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' 
                  SET quote = :quote, author_id = :author_id, category_id = :category_id 
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        return $stmt->execute();
    }

    // Delete quote
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Check if quote exists
    public function exists($id)
    {
        $query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>
