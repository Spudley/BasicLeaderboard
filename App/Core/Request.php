<?php
namespace App\Core;

/**
 * A very basic request object to pass into our controllers.
 * Simon Champion, April 2021.
 */
class Request
{
    private $json;

    public function __construct(string $location) {
        $this->json = json_decode(file_get_contents("php://input"), true);
    }

    public function getJson() {
        return $this->json;
    }

    public function __get($arg) {
        return $_REQUEST[$arg] ?? null;
    }
}

