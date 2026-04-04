<?php

class Contact
{
    private PDO $db;
    private string $name;
    private string $email;
    private string $subject;
    private string $message;
    private string $lastError = '';

    public function __construct(PDO $db, array $data)
    {
        $this->db = $db;
        $this->name = trim($data['name'] ?? '');
        $this->email = trim($data['email'] ?? '');
        $this->subject = trim($data['subject'] ?? '');
        $this->message = trim($data['message'] ?? '');
    }

    public function store(): bool
    {
        // validacia inputu
        if (empty($this->name) || empty($this->email) || empty($this->subject) || empty($this->message)) {
            $this->lastError = "Prosim, vyplň všetky polia!";
            return false;
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->lastError = "Email nemá správny formát!";
            return false;
        }

        // db
        try {
            $sql = "INSERT INTO messages (name, email, subject, message) 
                    VALUES (:name, :email, :subject, :message)";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                'name'    => $this->name,
                'email'   => $this->email,
                'subject' => $this->subject,
                'message' => $this->message
            ]);
        } catch (PDOException $e) {
            $this->lastError = "Chyba databázy: " . $e->getMessage();
            return false;
        }
    }
    // handling chyby
    public function getLastError(): string
    {
        return $this->lastError;
    }
}