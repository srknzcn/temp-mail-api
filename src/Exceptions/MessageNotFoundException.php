<?php
namespace TempMailAPI\Exceptions;

class MessageNotFoundException extends BaseException {
    protected $message = "No mail(s).";
}
