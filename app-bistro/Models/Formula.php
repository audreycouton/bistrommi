<?php

namespace App\Models;

class Formula extends Base
{
    protected $tableName = APP_TABLE_PREFIX . 'formula';
   

    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
   * Retourne les articles classés par dates.
   * @return void
   */
    public function getAllActive()
    {
        $sql = "SELECT * FROM {$this->tableName} ORDER BY created_at DESC";
        return self::$dbh->query($sql)->fetchAll();
    }

    /**
     * Retourne les articles associés à un auteur.
     * @return array
     */
    public function getByAuthor( $idauthor )
    {
        $sql = "SELECT * FROM {$this->tableName} 
            WHERE user_id = :id
            ORDER BY created_at DESC";
        $sth = self::$dbh->prepare($sql);
        $sth->bindValue(':id', $idauthor);
        $sth->execute();
        return $sth->fetchAll();
    }

    /**
     * Retourne toutes les informations sur les articles.
     * @return void
     */
    public function getAllDetailled(  )
    {
        $sql = "SELECT * FROM `{$this->tableName}` p, `{$this->tableUser}` u 
              WHERE p.user_id = u.id
              ORDER BY created_at DESC";
        return self::$dbh->query($sql)->fetchAll();
    }
}
