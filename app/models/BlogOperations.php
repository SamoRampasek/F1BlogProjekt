<?php
class BlogOperations
{
    private PDO $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addPost(string $title, string $category, string $content, string $author, string $image_url): bool
    {
        $sql = "INSERT INTO posts (title, category, content, author, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$title, $category, $content, $author, $image_url]);
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