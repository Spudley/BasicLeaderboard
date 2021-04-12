<?php
namespace App\Controller;

use App\Core\Request;
use App\Service\EntryService;
use App\Database\DB;

class CountEntries
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
     * Get request to count the number of entries
     */
    public function get()
    {
        $count = $this->service->count();
        return ['result' => 'success', 'data' => $count];
    }
}

