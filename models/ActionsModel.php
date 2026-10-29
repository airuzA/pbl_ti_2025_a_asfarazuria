<?php

require_once __DIR__ . '/../config/database.php';

use Ramsey\Uuid\Uuid;

class ActionsModel
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    public function getActions($search = '', $limit = null, $offset = 0)
    {
        $sql = "SELECT * FROM actions WHERE deleted_at IS NULL";
        $params = [];

        if ($search !== '') {
            $sql .= " AND (name LIKE ? OR description LIKE ?)";
            $keyword = '%' . $search . '%';
            $params = [$keyword, $keyword];
        }

        $sql .= " ORDER BY created_at DESC";
        if ($limit !== null) {
            $sql .= ' LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countActions($search = '')
    {
        $sql = "SELECT COUNT(*) FROM actions WHERE deleted_at IS NULL";
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

    public function getActionById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM actions
             WHERE id = ? AND deleted_at IS NULL"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public function createAction($data)
    {
        $id = Uuid::uuid4()->toString();

        $stmt = $this->db->prepare(
            "INSERT INTO actions
             (id, name, description, created_at)
             VALUES (?, ?, ?, NOW())"
        );
        $stmt->execute([$id, $data['name'], $data['description']]);

        return $id;
    }

    public function updateAction($id, $data)
    {
        $stmt = $this->db->prepare(
            "UPDATE actions
             SET name = ?, description = ?, updated_at = NOW()
             WHERE id = ? AND deleted_at IS NULL"
        );
        return $stmt->execute([$data['name'], $data['description'], $id]);
    }

    public function deleteAction($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE actions
             SET deleted_at = NOW()
             WHERE id = ? AND deleted_at IS NULL"
        );
        return $stmt->execute([$id]);
    }
}
