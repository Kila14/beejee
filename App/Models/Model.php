<?php

namespace App\Models;

abstract class Model
{
    protected \PDO | null $dbh = null;
    protected \PDOStatement|false $sth;
    protected string $sqlite_path = ROOT_PATH . '/App/DB/beejee.db';
    
    public function __construct()
    {
        $this->initDBH();
        $this->createTables();
    }
    
    protected function initDBH() : void
    {
        if (! is_null($this->dbh))
            return;
        
        try {
            $this->dbh = new \PDO("sqlite:$this->sqlite_path");
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function closeDBH() : void
    {
        $this->dbh = null;
    }
    
    public function execute(string $statement, $data = null, $fetch_mode = \PDO::FETCH_ASSOC): bool | \PDOStatement
    {
        $this->sth = $this->dbh->prepare($statement);
        
        if (! is_null($data))
            $this->sth->execute($data);
        else
            $this->sth->execute();
        
        $this->sth->setFetchMode($fetch_mode);
        
        return $this->sth;
    }
    
    protected function createTables() : void
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS tasks(
                id INTEGER PRIMARY KEY,
                user_name VARCHAR(255),
                user_email VARCHAR(255),
                task_description TEXT,
                task_status INT
            )
        ");
        
        $this->execute("
            CREATE TABLE IF NOT EXISTS task_statuses(
                id INTEGER PRIMARY KEY,
                title VARCHAR(255)
            )
        ");
    }
}