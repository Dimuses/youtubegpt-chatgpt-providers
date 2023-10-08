<?php

namespace dimuses\chatgpt\enums;

enum GptMessagesRoles: string
{
    case System = 'system';
    case Assistant = 'assistant';
    case User = 'user';
}
