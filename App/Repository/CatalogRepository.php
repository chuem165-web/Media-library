<?php

use App\Contract\CatalogRepositoryInterface;

class CatalogRepository extends BaseRepository implements CatalogRepositoryInterface
{
    protected string $table = 'view_catalog';
    protected ?string $getByIdProcedure = 'sp_get_item_full_detail';
    protected ?string $countProcedure = 'sp_search_catalog_count';


    
    public function search(string $keyword, ?string $category = null, ?int $limit = null, int $offset = 0): array
    {
        $stmt = $this->query("CALL sp_search_catalog (?, ?, ?, ?)");

        $stmt->bindValue(1, $keyword ?: null);
        $stmt->bindValue(2, $category ?: null);
        $stmt->bindValue(3, $limit, $limit ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(4, $offset, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->nextRowset();
        $stmt->closeCursor();

        return $data;
    }
    public function getByCategory(string $category, ?int $limit = null, int $offset = 0): array
    {
        $stmt = $this->query("CALL sp_get_catalog (?, ?, ?)");

        $stmt->bindValue(1, $category, PDO::PARAM_STR);
        $stmt->bindValue(2, $limit, $limit ? PDO::PARAM_INT : PDO::PARAM_NULL);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $data;
    }

    public function getRandom(): array
    {
        $stmt = $this->query("SELECT * FROM view_random");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $data;
    }

   

    
}