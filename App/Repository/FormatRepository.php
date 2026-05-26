<?php

class FormatRepository extends BaseRepository implements FormatRepositoryInterface
{
protected string $table = 'formats';
    public function get_format_drop_down($category = null)
    {
        $stmt = $this->query("CALL sp_get_formats_by_category (:category)");

        $stmt->bindValue(':category', $category, $category ? PDO::PARAM_STR : PDO::PARAM_NULL);

        $stmt->execute();

        $format = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $format[$row["category"]][] = $row["format"];
        }

        $stmt->closeCursor();

        return $format;
    }

    public function get_category_drop_down()
    {
        $stmt = $this->query(
            "SELECT DISTINCT category FROM view_catalog ORDER BY category"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function get_genres_drop_down($category = null)
    {
        $stmt = $this->query("CALL sp_get_genres_by_category (:category)");

        $stmt->bindValue(':category', $category, $category ? PDO::PARAM_STR : PDO::PARAM_NULL);

        $stmt->execute();

        $genre = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $genre[$row["category"]][] = $row["genre"];
        }

        $stmt->closeCursor();

        return $genre;
    }
}