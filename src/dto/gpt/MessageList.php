<?php

namespace dimuses\chatgpt\dto\gpt;

use dimuses\chatgpt\dto\Comment;

final class MessageList
{
    /**
     * @var array<int,Message>|Message[]
     */
    protected array $messages = [];

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * @param Message $message
     * @return void
     */
    public function addMessage(Message $message): void
    {
        $this->messages[] = $message;
    }
}