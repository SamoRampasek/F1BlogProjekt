<?php
class BlogOperations
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

    public function deletePost(int $id): bool
    {
        $stmtComments = $this->db->prepare("DELETE FROM comments WHERE post_id = ?");
        $stmtComments->execute([$id]);

        $stmtPost = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmtPost->execute([$id]);
    }

    public function deleteMessage(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM messages WHERE message_id = ?");
        return $stmt->execute([$id]);
    }
}