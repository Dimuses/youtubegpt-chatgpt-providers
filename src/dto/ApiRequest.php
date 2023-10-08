<?php
declare(strict_types=1);

namespace dimuses\chatgpt\dto;

final  class ApiRequest
{
    public function __construct(
        public readonly string|array $dataToSend,
    ) {
    }
}