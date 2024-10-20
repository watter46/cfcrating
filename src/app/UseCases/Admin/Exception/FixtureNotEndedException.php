<?php declare(strict_types=1);

namespace App\UseCases\Admin\Exception;

use Exception;


class FixtureNotEndedException extends Exception
{
    public function __construct($message = 'The fixture has not ended yet.')
    {
        parent::__construct($message);
    }
}