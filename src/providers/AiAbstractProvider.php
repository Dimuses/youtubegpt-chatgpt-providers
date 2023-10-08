<?php
declare(strict_types=1);

namespace dimuses\chatgpt\providers;

use dimuses\chatgpt\dto\{Answer, ApiRequest, Comment, AnswerSettingsList, Thread};

/**
 *
 */
abstract class AiAbstractProvider
{
    /**
     * @param string $accessToken
     */
    public function __construct(protected readonly string $accessToken)
    {
    }

    /**
     * @param AnswerSettingsList $settings
     * @return string
     */
    abstract public function tuneAnswer(AnswerSettingsList $settings): mixed;

    /**
     * @param string|Comment $comment
     * @return bool
     */
    abstract public function moderateComment(string|Comment $comment): bool;

    /**
     * @param string|Comment $comment
     * @return bool
     */
    abstract public function checkIfNeedAnswer(string|Comment $comment): bool;

    /**
     * @param string|Comment $comment
     * @return Answer
     */
    abstract public function generateAnswer(string|Comment $comment):  Answer;

    /**
     * @param Thread $thread
     * @param Comment $comment
     * @return Answer
     */
    abstract public function generateAnswerToThread(Thread $thread, Comment $comment): Answer;


    abstract public function parseAnswer($data): Answer;




}