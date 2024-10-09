<?php declare(strict_types=1);

namespace App\UseCases\Admin\Exception;

use Exception;


class ExistingColumnException extends Exception
{
    /**
     * カラムがNullでないとき例外を投げる
     *
     * @param  string $column
     */
    public function __construct(string $column)
    {
        $message = "The column $column already exists.";

        parent::__construct($message);
    }
}