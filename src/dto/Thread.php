<?php
declare(strict_types=1);

namespace dimuses\chatgpt\dto;

final class Thread
{
    /**
     * @var array<int,Comment>|Comment[]
     */
    protected array $comments = [];

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return void
     */
    public function addComment(Comment $comment): void
    {
        $this->comments[] = $comment;
    }
}