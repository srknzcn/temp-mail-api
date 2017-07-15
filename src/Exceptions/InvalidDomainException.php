<?php
namespace TempMailAPI\Exceptions;

class InvalidDomainException extends BaseException {
    protected $message = "Domain name must starts with @ (at) character.";
}
