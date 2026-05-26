<?php

namespace App\Repository;

use App\Contract\BaseRepositoryInterface;
use PDO;
use PDOStatement;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected PDO $db;
  protected ?string $getByIdProcedure = null;
  protected string $table;
  protected ?string $countProcedure = null;
  protected ?string $getAllProcedure = null;

     public function __construct(PDO $db)
    {
        $this->db = $db;
    }

   public function count(array $filters = []): int
{
    $search = $filters['search'] ?? null;
    $category = $filters['category'] ?? null;

    if ($this->countProcedure) {

        $stmt = $this->query("CALL {$this->countProcedure}(?, ?)");
        $stmt->bindValue(1, $search, $search ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(2, $category, $category ? PDO::PARAM_STR : PDO::PARAM_NULL);

    } else {

        // fallback SQL
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE 1=1";

        if ($search) {
            $sql .= " AND name LIKE :search";
        }

        if ($category) {
            $sql .= " AND category = :category";
        }

        $stmt = $this->query($sql);

        if ($search) {
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        }

        if ($category) {
            $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        }
    }

    $stmt->execute();
    $count = (int) $stmt->fetchColumn();

    $stmt->closeCursor();

    return $count;
}   

    public function getAll(?int $limit = null, int $offset = 0, array $filters = []): array
{
    if ($this->getAllProcedure) {

        $stmt = $this->query("CALL {$this->getAllProcedure}(?, ?)");

        $stmt->bindValue(1, $limit, $limit ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);

    } else {

        $sql = "SELECT * FROM {$this->table} WHERE 1=1";

        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->query($sql);

        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
    }

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $data;
}

  

public function getById(int $id): ?array
{
    if ($this->getByIdProcedure) {

        $stmt = $this->query(
            "CALL {$this->getByIdProcedure}(?)"
        );

        $stmt->bindValue(1, $id, PDO::PARAM_INT);

    } else {

        $stmt = $this->query(
            "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1"
        );

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    }

    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();

    return $data ?: null;
}

   

    /**
     * Execute prepared statement safely
     */
    protected function query(string $sql): PDOStatement
    {
        return $this->db->prepare($sql);
    }

    /**
     * Execute stored procedure with params
     */
    protected function call(string $procedure): PDOStatement
    {
        return $this->db->prepare("CALL {$procedure}");
    }
}