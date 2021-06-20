<?php
class Credit
{
    private $conn;
    private $table = 'credits';

    public $id;
    public $text;
    public $title;
    public $config;
    public $isPrivate;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read_single()
    {
        $query = 'SELECT p.id, p.text, p.config, p.isPrivate, p.title, p.password
                    FROM ' . $this->table . ' p
                    WHERE p.id = ?';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->text = $row['text'];
        $this->title = $row['title'];
        $this->config = $row['config'];
        $this->isPrivate = $row['isPrivate'];
        $this->password = $row['password'];
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '(title, text, config, isPrivate, password) VALUES(:title, :text, :config, :isPrivate, :password)';

        $stmt = $this->conn->prepare($query);

        $this->text = htmlspecialchars(strip_tags($this->text));
        $this->config = htmlspecialchars(strip_tags($this->config));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->password = htmlspecialchars(strip_tags($this->password));
        
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':config', $this->config);
        $stmt->bindParam(':isPrivate', $this->isPrivate);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
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

    public function read_password() 
    {
        $query = 'SELECT p.id, p.password
                    FROM ' . $this->table . ' p
                    WHERE p.id = ?';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->password = $row['password'];
    }
}
