<?php

namespace App\Exceptions;

use Exception;
use Auth;

class ProductNotMatchToUserException extends Exception
{
    public function render(){
    	return ["data"=> "product is Not belongs to user"];
    }
}
