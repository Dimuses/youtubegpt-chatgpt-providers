<?php
declare(strict_types=1);

namespace dimuses\chatgpt\external;


use CURLFile;
use dimuses\chatgpt\dto\Comment;
use dimuses\chatgpt\dto\gpt\MessageList;
use dimuses\chatgpt\enums\ImageGptSize;
use Orhanerday\OpenAi\OpenAi;

class ChatGptApi
{
    const DEFAULT_MODEL = 'gpt-3.5-turbo';
    const DEFAULT_TEMPERATURE = 1.0;
    const DEFAULT_MAX_TOKENS = 200;
    const DEFAULT_PENALTY = 0;
    const DEFAULT_FREQUENCY_PENALTY = 0;
    const DEFAULT_N_IMAGE = 1;


    /**
     * @var OpenAi
     */
    private readonly OpenAi $openAi;

    /**
     * @param string $accessToken
     * @param OpenAi|null $openAi
     */
    public function __construct(protected readonly string $accessToken, OpenAi $openAi = null)
    {
        $this->openAi = $openAi ?? new OpenAi($this->accessToken);
    }

    /**
     * @param MessageList $messageList
     * @return bool|string
     * @throws \Exception
     */
    public function sendChat(MessageList $messageList): bool|string
    {
        $messages = [];
        foreach ($messageList->getMessages() as $index => $message) {
            $messages[] = [
                'role'    => $message->role->value,
                'content' => $message->comment->text
            ];
        }
        return $this->openAi->chat([
            'model'             => self::DEFAULT_MODEL,
            'messages'          => $messages,
            'temperature'       => self::DEFAULT_TEMPERATURE,
            'max_tokens'        => self::DEFAULT_MAX_TOKENS,
//            'frequency_penalty' => self::DEFAULT_FREQUENCY_PENALTY,
//            'presence_penalty'  => self::DEFAULT_PENALTY,
        ]);
    }

    /**
     * @param Comment|string $comment
     * @return bool|string
     */
    public function moderateComment(Comment|string $comment): bool|string
    {
        return $this->openAi->moderation([
            'input' => $comment?->text ?? $comment
        ]);
    }

    /**
     * @param CURLFile $file
     * @return bool|string
     */
    public function transcribeAudio(CURLFile $file): bool|string
    {
        return $this->openAi->transcribe([
            "model" => "whisper-1",
            "file"  => $file,
        ]);
    }

    public function imageEdit(CURLFile     $otter,
                              CURLFile     $mask,
                              ImageGptSize $imageGptSize,
                              ?string      $prompt): bool|string
    {
        return $this->openAi->imageEdit([
            "image"  => $otter,
            "mask"   => $mask,
            "prompt" => $prompt,
            "n"      => self::DEFAULT_N_IMAGE,
            "size"   => $imageGptSize->value,
        ]);
    }

    public function createImage(ImageGptSize $imageGptSize,
                                ?string      $prompt): bool|string
    {
        return $this->openAi->image([
            "prompt"          => $prompt,
            "n"               => self::DEFAULT_N_IMAGE,
            "size"            => $imageGptSize->value,
            "response_format" => "url",
        ]);
    }


}