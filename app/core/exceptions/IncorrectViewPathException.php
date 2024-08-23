<?php

namespace app\core\exceptions;

class IncorrectViewPathException extends \Exception
{
    protected $message = "Unexpected view path";
}