<?php
namespace TempMailAPI\Exceptions;

class UndefinedDomainException extends BaseException {
    protected $message = "Domain is undefined.";
}
