<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongToUser extends Exception
{
    public function render()
    {
        return response()->json([ __('message.ProductNotBelongToUser')], 404);
        
    }
}
