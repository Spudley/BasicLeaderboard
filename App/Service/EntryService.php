<?php
namespace App\Service;

use App\Model\Entry;
use App\Database\DB;

class EntryService
{
    private $db;
    private $table;

    public function __construct(DB $db)
    {
        $this->db = $db;
        $tableClass = $db->getTableClass('Entries');
        $this->table = new $tableClass($db);
    }

    public function create(string $username, int $score)
    {
        //@todo: validate that username doesn't already exist.
        $entry = new Entry;
        $entry->setUsername($username);
        $entry->setScore($score);
        $this->table->save($entry);
        return true;
    }

    public function update(string $username, int $score)
    {
        $entry = $this->loadByUsername($username);
        $entry->setScore($score);
        $this->table->save($entry);
        return true;
    }

    public function delete(string $username)
    {
        $this->table->delete($username);
        return true;
    }

    public function load($limit, $start): array
    {
        return $this->table->load($limit, $start);
    }

    public function loadByUsername(string $username): ?Entry
    {
        return $this->table->loadByUsername($username);
    }

    public function count(): int
    {
        return $this->table->count();
    }

    public function averageScore(): float
    {
        return $this->table->averageScore();
    }

    public function topScores(int $quantity): array
    {
        return $this->table->topScores($quantity);
    }
}

