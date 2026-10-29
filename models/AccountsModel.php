<?php

require_once __DIR__ . '/../config/database.php';

use Ramsey\Uuid\Uuid;

class AccountsModel
{
    private $db;

    public function __construct()
    {
        global $conn;
        $this->db = $conn;
    }

    public function getAccounts($search = '', $limit = null, $offset = 0)
    {
        $sql = "
            SELECT a.*, at.name AS account_type_name
            FROM accounts a
            INNER JOIN account_type at ON at.id = a.account_type_id
            WHERE a.deleted_at IS NULL
              AND at.deleted_at IS NULL
        ";
        $params = [];

        if ($search !== '') {
            $sql .= "
                AND (
                    a.name LIKE ?
                    OR a.email LIKE ?
                    OR a.identification_number LIKE ?
                    OR a.username LIKE ?
                )
            ";
            $keyword = '%' . $search . '%';
            $params = [$keyword, $keyword, $keyword, $keyword];
        }

        $sql .= ' ORDER BY a.created_at DESC';
        if ($limit !== null) {
            $sql .= ' LIMIT ? OFFSET ?';
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

    public function countAccounts($search = '')
    {
        $sql = "
            SELECT COUNT(*)
            FROM accounts a
            INNER JOIN account_type at ON at.id = a.account_type_id
            WHERE a.deleted_at IS NULL
              AND at.deleted_at IS NULL
        ";
        $params = [];

        if ($search !== '') {
            $sql .= "
                AND (
                    a.name LIKE ?
                    OR a.email LIKE ?
                    OR a.identification_number LIKE ?
                    OR a.username LIKE ?
                )
            ";
            $keyword = '%' . $search . '%';
            $params = [$keyword, $keyword, $keyword, $keyword];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn();
    }

    public function getAccountById($id)
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM accounts WHERE id = ? AND deleted_at IS NULL'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM accounts
             WHERE email = ?
             AND status = ?
             AND deleted_at IS NULL'
        );
        $stmt->execute([$email, 'aktif']);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    public function emailExists($email, $exceptId = null)
    {
        $sql = 'SELECT id FROM accounts WHERE email = ? AND deleted_at IS NULL';
        $params = [$email];

        if ($exceptId !== null) {
            $sql .= ' AND id != ?';
            $params[] = $exceptId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch() !== false;
    }

    public function usernameExists(string $username, $excludeId = null): bool
    {
        $sql = 'SELECT COUNT(*) FROM accounts WHERE username = :username';
        $params = ['username' => $username];

        if ($excludeId !== null) {
            $sql .= ' AND id != :id';
            $params['id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }


    public function createAccount($data)
    {
        $id = Uuid::uuid4()->toString();

        $stmt = $this->db->prepare(
            'INSERT INTO accounts
            (id, name, email, password, account_type_id, status,
             identification_number, identification_type, created_at, username)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)'
        );
        $stmt->execute([
            $id,
            $data['name'],
            $data['email'],
            $data['password'],
            $data['account_type_id'],
            $data['status'],
            $data['identification_number'],
            $data['identification_type'],
            $data['username'],
        ]);

        return $id;
    }

    public function updateAccount($id, $data)
    {
        $sql = "
            UPDATE accounts
            SET name = ?, email = ?, account_type_id = ?, status = ?,
                identification_number = ?, identification_type = ?, username = ?,
                updated_at = NOW()
        ";
        $params = [
            $data['name'],
            $data['email'],
            $data['account_type_id'],
            $data['status'],
            $data['identification_number'],
            $data['identification_type'],
            $data['username'],
        ];

        if (!empty($data['password'])) {
            $sql .= ', password = ?';
            $params[] = $data['password'];
        }

        $sql .= ' WHERE id = ? AND deleted_at IS NULL';
        $params[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteAccount($id)
    {
        $stmt = $this->db->prepare(
            'UPDATE accounts SET deleted_at = NOW()
             WHERE id = ? AND deleted_at IS NULL'
        );

        return $stmt->execute([$id]);
    }
}
