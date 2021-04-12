<?php
namespace App\Controller;

use App\Core\Request;
use App\Service\EntryService;
use App\Database\DB;

class TopScores
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
     * Get request to list all or some entries
     */
    public function get()
    {
        $entries = $this->service->topScores((int)$this->request->quantity);
        return ['result' => 'success', 'data' => $entries];
    }
}

