<?php

abstract class BaseRepository
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
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