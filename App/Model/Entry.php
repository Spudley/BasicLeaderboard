<?php
namespace App\Model;

use JsonSerializable;

/**
 * Very basic class to model the database record and interact with the DB.
 */
class Entry implements JsonSerializable
{
    protected $id; // the requirements only talk about username, but I believe all DB tables need an ID as the primary key.
    protected $username;
    protected $score;
    protected $counter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score)
    {
        $this->score = max($score, $this->score);
        $this->counter++;
    }

    public function getCounter(): ?int
    {
        return $this->counter;
    }

    public function jsonSerialize() {
        return ['username' => $this->username, 'score'=>$this->score];
    }
}

