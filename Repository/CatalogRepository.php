<?php

class CatalogRepository extends BaseRepository implements CatalogRepositoryInterface
{
    // Get total catalog item count
    public function getcatalog_count($category = null, $search = null)
    {
        $stmt = $this->query(
            "CALL sp_search_catalog_count (:search , :category)"
        );

        $stmt->bindValue(':search', $search, $search ? PDO::PARAM_STR : PDO::PARAM_NULL);
        $stmt->bindValue(':category', $category, $category ? PDO::PARAM_STR : PDO::PARAM_NULL);

        $stmt->execute();

        $count = $stmt->fetchColumn();

        $stmt->nextRowset();
        $stmt->closeCursor();

        return $count;
    }

    public function get_full_catalog($limit = null, $offset = 0)
    {
        $stmt = $this->query("CALL sp_get_full_catalog (?, ?)");

        $stmt->bindValue(1, $limit, $limit ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll();
        $stmt->closeCursor();

        return $data;
    }

    public function get_category_catalog($category, $limit = null, $offset = 0)
    {
        $stmt = $this->query("CALL sp_get_catalog (?, ?, ?)");

        $stmt->bindValue(1, $category, PDO::PARAM_STR);
        $stmt->bindValue(2, $limit, $limit ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll();
        $stmt->closeCursor();

        return $data;
    }

    public function get_search_catalog($search, $category = null, $limit = null, $offset = 0)
    {
        $stmt = $this->query("CALL sp_search_catalog (?, ?, ?, ?)");

        $stmt->bindValue(1, $search ?: null);
        $stmt->bindValue(2, $category ?: null);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->bindValue(4, $offset, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll();
        $stmt->nextRowset();
        $stmt->closeCursor();

        return $data;
    }

    public function get_random_catalog()
    {
        $stmt = $this->query("SELECT * FROM view_random");
        return $stmt->fetchAll();
    }

    public function get_single_item($id): ?array
    {
        $stmt = $this->query("CALL sp_get_item_full_detail (?)");

        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            $stmt->closeCursor();
            return null;
        }

        $stmt->nextRowset();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item[strtolower($row['role'])][] = $row['fullname'];
        }

        $stmt->closeCursor();

        return $item;
    }
}