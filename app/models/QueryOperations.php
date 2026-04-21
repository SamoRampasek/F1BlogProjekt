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

    public function getPostById(int $id)
    {
        $query = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetch();
    }

    public function commentControl(int $postId, array $postData): bool
    {
        if (isset($postData['submit_comment'])) {
            $name = trim($postData['name'] ?? '');
            $email = trim($postData['email'] ?? '');
            $message = trim($postData['message'] ?? '');
            
            if (!empty($name) && !empty($email) && !empty($message)) {
                return $this->addComment($name, $email, $message, $postId);
            }
        }
        
        return false;
    }

    public function addComment(string $name, string $email, string $message, int $postId): bool
    {
        $query = "INSERT INTO comments (name, email, message, post_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([$name, $email, $message, $postId]);
    }

    public function getComments(int $postId): array
    {
        $query = "SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$postId]);
        
        return $stmt->fetchAll();
    }

    public function updatePost(int $id, array $postData, string $author): bool
    {
        $query = "UPDATE posts SET title = ?, category = ?, author = ?, image_url = ?, content = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $postData['title'] ?? '',
            $postData['category'] ?? '',
            $author,
            $postData['image_url'] ?? '',
            $postData['content'] ?? '',
            $id
        ]);
    }

    public function addPost(array $postData, string $author): bool
    {
        $query = "INSERT INTO posts (title, category, content, author, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([
            $postData['title'] ?? '',
            $postData['category'] ?? '',
            $postData['content'] ?? '',
            $author,
            $postData['image_url'] ?? ''
        ]);
    }
}