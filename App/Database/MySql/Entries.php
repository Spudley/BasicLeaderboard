<?php
namespace App\Database\MySql;

use App\Model\Entry;

class Entries
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function delete(string $username)
    {
        $sql = "DELETE from entries where username=:username";
        $args = [':username' => $username];
        $this->db->execute($sql, $args);
    }

    public function load($limit, $start): array
    {
        $sql = "SELECT id, username, score, counter from entries";
        $args = [];
        if ($start || $limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $args = [':limit' => $limit, ':offset' => $start];
        }
        return $this->db->query($sql, $args, Entry::class);
    }

    public function loadByUsername(string $username): ?Entry
    {
        $sql = "SELECT id, username, score, counter from entries where username=:username";
        $args = [':username' => $username];
        $entries = $this->db->query($sql, $args, Entry::class);
        if (count($entries) !== 1) {
            return null;
        }
        return array_pop($entries);
    }

    public function save(Entry $entry)
    {
        if(is_null($entry->getId())) {
            $sql = "INSERT into entries (username, score) values (:username, :score)";
        } else {
            $sql = "UPDATE entries set score = :score where username = :username";
        }
        $args = [':username' => $entry->getUsername(), ':score' => $entry->getScore()];
        $this->db->execute($sql, $args);
        
        if(is_null($entry->getId())) {
            $entry->setId($this->db->getPDO()->lastInsertId());
        }
    }

    public function count(): ?int
    {
        $sql = "SELECT count(username) ctr from entries";
        $args = [];
        $data = $this->db->query($sql, $args);
        return $data[0]->ctr;
    }

    public function averageScore(): float
    {
        $sql = "SELECT avg(score) average from entries";
        $args = [];
        $data = $this->db->query($sql, $args);
        return $data[0]->average;
    }

    public function topScores(?int $quantity): array
    {
        $sql = "SELECT id, username, score, counter from entries order by score desc";
        $args = [];
        if ($quantity) {
            $sql .= " LIMIT :limit";
            $args = [':limit' => $quantity];
        }
        return $this->db->query($sql, $args, Entry::class);
    }
}

