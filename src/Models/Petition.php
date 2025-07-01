<?php

namespace App\Models;

use App\Database;

class Petition
{
    private $db;
    
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
    
    public function create(array $data): int
    {
        // Referans numarası oluştur
        $referenceNumber = $this->generateReferenceNumber();
        
        $sql = "INSERT INTO petitions (user_id, category_id, title, content, ai_generated, status, priority, reference_number) 
                VALUES (:user_id, :category_id, :title, :content, :ai_generated, :status, :priority, :reference_number)";
        
        return $this->db->insert($sql, [
            'user_id' => $data['user_id'],
            'category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'content' => $data['content'],
            'ai_generated' => $data['ai_generated'] ?? false,
            'status' => $data['status'] ?? 'draft',
            'priority' => $data['priority'] ?? 'medium',
            'reference_number' => $referenceNumber
        ]);
    }
    
    public function findById(int $id): ?array
    {
        $sql = "SELECT p.*, c.name as category_name, c.icon as category_icon,
                       u.full_name as user_name, u.email as user_email,
                       a.full_name as assigned_to_name
                FROM petitions p
                LEFT JOIN petition_categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN users a ON p.assigned_to = a.id
                WHERE p.id = :id";
        
        return $this->db->queryOne($sql, ['id' => $id]);
    }
    
    public function findByReferenceNumber(string $referenceNumber): ?array
    {
        $sql = "SELECT p.*, c.name as category_name, u.full_name as user_name
                FROM petitions p
                LEFT JOIN petition_categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.reference_number = :reference_number";
        
        return $this->db->queryOne($sql, ['reference_number' => $referenceNumber]);
    }
    
    public function getByUserId(int $userId, int $limit = 20, int $offset = 0): array
    {
        $sql = "SELECT p.*, c.name as category_name, c.icon as category_icon
                FROM petitions p
                LEFT JOIN petition_categories c ON p.category_id = c.id
                WHERE p.user_id = :user_id
                ORDER BY p.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        return $this->db->query($sql, [
            'user_id' => $userId,
            'limit' => $limit,
            'offset' => $offset
        ]);
    }
    
    public function getAll(array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $where = [];
        $params = ['limit' => $limit, 'offset' => $offset];
        
        if (!empty($filters['status'])) {
            $where[] = "p.status = :status";
            $params['status'] = $filters['status'];
        }
        
        if (!empty($filters['category_id'])) {
            $where[] = "p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }
        
        if (!empty($filters['priority'])) {
            $where[] = "p.priority = :priority";
            $params['priority'] = $filters['priority'];
        }
        
        if (!empty($filters['assigned_to'])) {
            $where[] = "p.assigned_to = :assigned_to";
            $params['assigned_to'] = $filters['assigned_to'];
        }
        
        if (!empty($filters['search'])) {
            $where[] = "(p.title LIKE :search OR p.content LIKE :search OR p.reference_number LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }
        
        $whereClause = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);
        
        $sql = "SELECT p.*, c.name as category_name, c.icon as category_icon,
                       u.full_name as user_name, a.full_name as assigned_to_name
                FROM petitions p
                LEFT JOIN petition_categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN users a ON p.assigned_to = a.id
                {$whereClause}
                ORDER BY 
                    CASE p.priority 
                        WHEN 'urgent' THEN 1 
                        WHEN 'high' THEN 2 
                        WHEN 'medium' THEN 3 
                        WHEN 'low' THEN 4 
                    END,
                    p.created_at DESC
                LIMIT :limit OFFSET :offset";
        
        return $this->db->query($sql, $params);
    }
    
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = ['id' => $id];
        
        $allowedFields = ['category_id', 'title', 'content', 'status', 'priority', 'assigned_to'];
        
        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $fields[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
        }
        
        if (isset($data['status']) && $data['status'] === 'submitted' && !isset($data['submitted_at'])) {
            $fields[] = "submitted_at = NOW()";
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE petitions SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id";
        return $this->db->update($sql, $params) > 0;
    }
    
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM petitions WHERE id = :id";
        return $this->db->delete($sql, ['id' => $id]) > 0;
    }
    
    public function getStatistics(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'draft' THEN 1 ELSE 0 END) as draft,
                    SUM(CASE WHEN status = 'submitted' THEN 1 ELSE 0 END) as submitted,
                    SUM(CASE WHEN status = 'in_review' THEN 1 ELSE 0 END) as in_review,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN priority = 'urgent' THEN 1 ELSE 0 END) as urgent,
                    SUM(CASE WHEN ai_generated = 1 THEN 1 ELSE 0 END) as ai_generated
                FROM petitions";
        
        return $this->db->queryOne($sql) ?? [];
    }
    
    public function getRecentPetitions(int $limit = 10): array
    {
        $sql = "SELECT p.id, p.title, p.status, p.priority, p.created_at,
                       u.full_name as user_name, c.name as category_name
                FROM petitions p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN petition_categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC
                LIMIT :limit";
        
        return $this->db->query($sql, ['limit' => $limit]);
    }
    
    private function generateReferenceNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        
        // Bu ay kaç dilekçe var?
        $sql = "SELECT COUNT(*) as count FROM petitions WHERE YEAR(created_at) = :year AND MONTH(created_at) = :month";
        $result = $this->db->queryOne($sql, ['year' => $year, 'month' => $month]);
        $count = ($result['count'] ?? 0) + 1;
        
        return sprintf('DLK-%s%s-%04d', $year, $month, $count);
    }
}