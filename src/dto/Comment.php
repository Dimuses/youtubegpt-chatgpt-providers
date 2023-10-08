<?php
declare(strict_types=1);

namespace dimuses\chatgpt\dto;

final class Comment
{
    public function __construct(
        public readonly string $text,
        public readonly ?string $id = null,
        public readonly ?int $timestamp = null
    ) {
    }
}