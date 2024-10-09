<?php declare(strict_types=1);

namespace App\UseCases\Admin\Exception;

use Exception;


class InvalidColumnException extends Exception
{
    public function __construct($column)
    {
        $message = "The column $column is invalid or does not exist.";

        parent::__construct($message);
    }
}