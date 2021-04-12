<?php
namespace App\Database\Session;

use App\Model\Entry;

class Entries
{
    public function __construct(DB $db)
    {
        
    }

    public function delete(string $username)
    {
        $entry = $this->loadByUsername($username);
        unset($_SESSION['entries'][$entry->getId()]);
    }

    public function load($limit, $start): array
    {
        return array_values($_SESSION['entries'] ?? []);
    }

    public function loadByUsername(string $username): ?Entry
    {
        foreach ($_SESSION['entries'] as $entry) {
            if ($entry->getUsername() === $username) {
                return $entry;
            }
        }
        return null;
    }

    public function save(Entry $entry)
    {
        if(is_null($entry->getId())) {
            $entry->setId(count($_SESSION['entries'] ?? []));
            $_SESSION['entries'][] = $entry;
            return;
        }
        $_SESSION['entries'][$entry->getId()] = $entry;
    }

    public function count(): int
    {
        return count($_SESSION['entries'] ?? []);
    }

    public function averageScore(): float
    {
        $total = 0;
        foreach ($_SESSION['entries'] as $entry) {
            $total += $entry->getScore();
        }
        return $total / count($_SESSION['entries']);
    }

    public function topScores(int $quantity): array
    {
        $entries = array_values($_SESSION['entries']);
        usort($entries, function($a, $b) {
            return $b->getScore() <=> $a->getScore();
        });
        return array_slice($entries, 0, $quantity);
    }
}

