<?php
declare(strict_types=1);

namespace dimuses\chatgpt\providers;

use dimuses\chatgpt\dto\{Answer, AnswerSettingsList, ApiRequest, Comment, gpt\Message, gpt\MessageList, Thread};
use dimuses\chatgpt\enums\GptMessagesRoles;
use dimuses\chatgpt\external\ChatGptApi;

class ChatGptProvider extends AiAbstractProvider
{
    private AnswerSettingsList $settingList;

    public function parseAnswer($data): Answer
    {
        $text = '';
        return new Answer($text);
    }

    public function tuneAnswer(AnswerSettingsList $settings): Message
    {
        $masterPrompt = '';
        foreach ($settings->getSettings() as $index => $setting) {
            $masterPrompt .= $index == 0
                ? $setting->prompt
                : '. ' . $setting->prompt;
        }
        return new Message(
            new Comment($masterPrompt),
            GptMessagesRoles::Assistant
        );
    }


    public function moderateComment(Comment|string $comment): bool
    {
        $data = json_decode($this->api->moderateComment($comment));
        return $data?->results[0]?->flagged;
    }

    public function checkIfNeedAnswer(Comment|string $comment): bool
    {
        return false;
    }

    public function generateAnswer(Comment|string $comment): Answer
    {
        $userMessage = new Message($comment);
        $messageList = new MessageList();
        $systemMessage = $this->tuneAnswer($this->getSettingsList());
        $messageList->addMessage($systemMessage);
        $messageList->addMessage($userMessage);

        $gptAnswer = $this->api->sendChat($messageList);
        $gptAnswer = json_decode($gptAnswer);
        $text = $gptAnswer?->choices[0]?->message?->content ?? '';

        return new Answer($text);
    }

    public function generateAnswerToThread(Thread $thread, Comment $comment): Answer
    {
        $text = '';
        return new Answer($text);
    }

    protected readonly ChatGptApi $api;

    public function __construct(
        string $accessToken,
        ChatGptApi $api = null
    )
    {
        $this->api = $api ?? new ChatGptApi($accessToken);

        parent::__construct($accessToken);
    }

    protected function getSettingsList(): AnswerSettingsList
    {
        return $this->settingList;
    }

    public function setSettingList(AnswerSettingsList $getSettingsList): void
    {
        $this->settingList = $getSettingsList;
    }
}