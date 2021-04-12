<?php
namespace App\Controller;

use App\Core\Request;
use App\Service\EntryService;
use App\Database\DB;

class AverageScore
{
    private $request;
    private $service;
    private $db;

    public function __construct(Request $request, DB $db)
    {
        $this->request = $request;
        $this->db = $db;
        $this->service = new EntryService($db);
    }

    /**
     * Get request to return the average score
     */
    public function get()
    {
        $average = $this->service->averageScore();
        return ['result' => 'success', 'data' => $average];
    }
}

