<?php
class Credit
{
    private $conn;
    private $table = 'credits';

    public $id;
    public $text;
    public $config;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_single()
    {
        $query = 'SELECT p.id, p.text, p.config
                    FROM ' . $this->table . ' p
                    WHERE p.id = ?';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->text = $row['text'];
        $this->config = $row['config'];
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '(text, config) VALUES(:text, :config)';

        $stmt = $this->conn->prepare($query);

        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->config = htmlspecialchars(strip_tags($this->config));

        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':config', $this->config);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                                SET text = :text, config = :config
                                WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->config = htmlspecialchars(strip_tags($this->config));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':config', $this->config);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
