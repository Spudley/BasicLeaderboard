<?php
namespace App\Controller;

use App\Core\Request;
use App\Service\EntryService;
use App\Database\DB;

class ListEntries
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
        $entries = $this->service->load($this->request->limit, $this->request->start);
        return ['result' => 'success', 'data' => $entries];
    }
}

