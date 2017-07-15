<?php
namespace TempMailAPI\Exceptions;

class FullMailAddressException extends BaseException {
    protected $message = "Full mail address required.";
}
