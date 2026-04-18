<?php
class QueryOperations
{
    private PDO $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getRecentPosts(): array
    {
        $query = "SELECT id, title, created_at FROM posts ORDER BY created_at DESC LIMIT 3";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getCategories(): array
    {
        $query = "SELECT category, COUNT(*) as post_count FROM posts GROUP BY category ORDER BY category ASC";
        $stmt = $this->db->query($query);

        return $stmt->fetchAll();
    }

    public function getPosts(): array
    {
        $query = "SELECT posts.*, COUNT(comments.post_id) AS comment_count 
              FROM posts 
              LEFT JOIN comments ON posts.id = comments.post_id 
              GROUP BY posts.id 
              ORDER BY posts.created_at DESC 
              LIMIT 4";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getAllPosts(?string $category = null): array
    {
        if ($category) {
            $query = "SELECT * FROM posts WHERE category = :category ORDER BY created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['category' => $category]);
            
            return $stmt->fetchAll();
        }

        $query = "SELECT * FROM posts ORDER BY created_at DESC";
        $stmt = $this->db->query($query);
        
        return $stmt->fetchAll();
    }

    public function getAllMessages(): array
    {
        $query = "SELECT message_id, subject, message, email, created_at FROM messages ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}