<?php

namespace dimuses\chatgpt\dto\gpt;

use dimuses\chatgpt\dto\Comment;
use dimuses\chatgpt\enums\GptMessagesRoles;

final class Message
{

    public function __construct(
        readonly Comment $comment,
        readonly GptMessagesRoles $role = GptMessagesRoles::User,
    )
    {
    }
}