<?php
declare(strict_types=1);

namespace dimuses\chatgpt\exceptions;

final class EmptyMessageException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Provided message to post is empty!", 500);
    }
}