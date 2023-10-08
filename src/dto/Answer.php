<?php

namespace dimuses\chatgpt\dto;

final class Answer
{
    public function __construct(
        public readonly string $text,
        public readonly ?string $id = null,
        public readonly ?int $timestamp = null
    ) {
    }
}