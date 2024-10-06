<?php declare(strict_types=1);

namespace App\UseCases\Admin\Exception;

use Exception;

class InvalidAdminKeyException extends Exception
{
    public function __construct($message = "Invalid admin key provided.")
    {
        parent::__construct($message);
    }
}