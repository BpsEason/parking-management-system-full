<?php
namespace App\Exceptions;
use Exception;
use Throwable;
class NoAvailableSpaceException extends Exception
{
    public function __construct($message = "No available parking spaces.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
