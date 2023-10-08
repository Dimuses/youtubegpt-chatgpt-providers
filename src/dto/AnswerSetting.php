<?php

namespace dimuses\chatgpt\dto;

final class AnswerSetting
{

    public function __construct(
        readonly public string $prompt,
        readonly public ?string $additionalPrompt = null,
    )
    {
    }
}