<?php
class BlogOperations
{
    private PDO $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function deletePost(int $id): bool
    {
        $stmtC = $this->db->prepare("DELETE FROM comments WHERE post_id = ?");
        $stmtC->execute([$id]);

        $stmtP = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmtP->execute([$id]);
    }

    public function deleteMessage(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM messages WHERE message_id = ?");
        return $stmt->execute([$id]);
    }
}