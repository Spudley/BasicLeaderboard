<?php
namespace App\Controller;

use App\Core\Request;
use App\Service\EntryService;
use App\Database\DB;

class Entry
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
     * Post request to create an entry
     */
    public function post()
    {
        $postData = $this->request->getJson();
        if (!($postData['username'] ?? null) || !($postData['score'] ?? null)) {
            return ['result'=>'error', 'message'=>'Invalid post data'];
        }
        $success = $this->service->create($postData['username'], (int)$postData['score']);
        return ['result' => ($success ? 'success' : 'error')];
    }

    /**
     * Patch request to update an entry
     */
    public function patch()
    {
        $postData = $this->request->getJson();
        if (!$postData['username'] ?? null || !$postData['score'] ?? null) {
            return ['result'=>'error', 'message'=>'Invalid patch data'];
        }
        $success = $this->service->update($postData['username'], (int)$postData['score']);
        return ['result' => ($success ? 'success' : 'error')];
    }

    /**
     * Delete request to update an entry
     */
    public function delete()
    {
        $postData = $this->request->getJson();
        if (!$postData['username'] ?? null) {
            return ['result'=>'error', 'message'=>'Invalid delete data'];
        }
        $success = $this->service->delete($postData['username']);
        return ['result' => ($success ? 'success' : 'error')];
    }

    /**
     * Get request to get a single entry (may not need this for the basic app specified?)
     */
    public function get()
    {
        $username = $this->request->username;
        if (!$username) {
            return ['result'=>'error', 'message'=>'Invalid get data'];
        }
        $record = $this->service->loadByUsername($username);
        if ($record) {
            return ['result' => 'success', 'data' => ['username' => $record['username'], 'score' => $record['score']]];
        }
        return ['result' => 'error'];
    }
}

