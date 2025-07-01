<?php

namespace App\Models;

use App\Database;
use PDO;

class User
{
    private $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function create(array $data): int
    {
        $sql = "INSERT INTO users (username, email, password, full_name, phone, address, role) 
                VALUES (:username, :email, :password, :full_name, :phone, :address, :role)";
        
        return $this->db->insert($sql, [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'full_name' => $data['full_name'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'role' => $data['role'] ?? 'user'
        ]);
    }
    
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        return $this->db->queryOne($sql, ['email' => $email]);
    }
    
    public function findByUsername(string $username): ?array
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        return $this->db->queryOne($sql, ['username' => $username]);
    }
    
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->db->queryOne($sql, ['id' => $id]);
    }
    
    public function authenticate(string $login, string $password): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :login OR username = :login";
        $user = $this->db->queryOne($sql, ['login' => $login]);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Şifreyi döndürmeme
            return $user;
        }
        
        return null;
    }
    
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];
        
        foreach ($data as $key => $value) {
            if (in_array($key, ['username', 'email', 'full_name', 'phone', 'address', 'role'])) {
                $fields[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }
        
        if (isset($data['password'])) {
            $fields[] = "password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
        return $this->db->update($sql, $params) > 0;
    }
    
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        return $this->db->delete($sql, ['id' => $id]) > 0;
    }
    
    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $sql = "SELECT id, username, email, full_name, phone, role, created_at 
                FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        return $this->db->query($sql, ['limit' => $limit, 'offset' => $offset]);
    }
    
    public function getOfficers(): array
    {
        $sql = "SELECT id, username, full_name FROM users WHERE role IN ('admin', 'officer') ORDER BY full_name";
        return $this->db->query($sql);
    }
    
    public function getTotalCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM users";
        $result = $this->db->queryOne($sql);
        return $result['count'] ?? 0;
    }
}