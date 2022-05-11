<?php

namespace App\Http\Exceptions;

use Exception;

class InvalidOrderException extends Exception
{
    /**
     * Get the exception's context information.
     *
     * @return array
     */
    public function context()
    {
        return ['order_id' => $this->orderId];
    }
}
