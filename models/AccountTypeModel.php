<?php

require_once __DIR__ . '/../config/database.php';

use Ramsey\Uuid\Uuid;

class AccountTypeModel
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    public function getAccountType($search = '', $limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM account_type WHERE deleted_at IS NULL";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
            $keyword = '%' . $search . '%';
            $params = [$keyword, $keyword];
        }

        $sql .= " ORDER BY created_at DESC";

        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $index => $param) {
            $stmt->bindValue($index + 1, $param, PDO::PARAM_STR);
        }

        if ($limit !== null) {
            $stmt->bindValue(count($params) + 1, max(1, (int) $limit), PDO::PARAM_INT);
            $stmt->bindValue(count($params) + 2, max(0, (int) $offset), PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAccountTypes($search = '')
    {
        $sql = "SELECT COUNT(*) FROM account_type WHERE deleted_at IS NULL";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
            $keyword = '%' . $search . '%';
            $params = [$keyword, $keyword];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function getAccountTypeById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM account_type WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public function createAccountType($data)
    {
        $id = Uuid::uuid4()->toString();

        $stmt = $this->db->prepare("INSERT INTO account_type (id, name, description, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$id, $data['name'], $data['description']]);

        return $id;
    }

    public function updateAccountType($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE account_type SET name = ?, description = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$data['name'], $data['description'], $id]);
    }

    public function deleteAccountType($id)
    {
        $stmt = $this->db->prepare("UPDATE account_type SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL");
        return $stmt->execute([$id]);
    }
}
