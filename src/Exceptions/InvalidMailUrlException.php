<?php
namespace TempMailAPI\Exceptions;

class InvalidMailUrlException extends BaseException {
    protected $message = "Read Mail url must be defined.";
}
