<?php

namespace units\providers;

use dimuses\chatgpt\dto\Answer;
use dimuses\chatgpt\dto\AnswerSetting;
use dimuses\chatgpt\dto\AnswerSettingsList;
use dimuses\chatgpt\dto\Comment;
use dimuses\chatgpt\dto\gpt\Message;
use dimuses\chatgpt\enums\GptMessagesRoles;
use dimuses\chatgpt\external\ChatGptApi;
use dimuses\chatgpt\providers\ChatGptProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers MyClass::methodToTest
 */
class ChatGptProviderTest extends TestCase
{
    private ChatGptProvider $dataProvider;


    private function getSettingsList(): AnswerSettingsList
    {
        $settingOne = new AnswerSetting('Ты администратор Youtube канала');
        $settingTwo = new AnswerSetting('Ты отвечаешь только на том языке на котором был задан вопрос');
        $settingThree = new AnswerSetting('Ты должен отвечать на комментарии пользователей соблюдая краткость и красноречие');
        $settingFour = new AnswerSetting('Длина сообщения должна быть 10 слов');

        $settingsList = new AnswerSettingsList();
        $settingsList->addSetting($settingOne);
        $settingsList->addSetting($settingTwo);
        $settingsList->addSetting($settingThree);
        $settingsList->addSetting($settingFour);

        return $settingsList;
    }


    protected function setUp(): void
    {
        $this->dataProvider = new ChatGptProvider(getenv('CHATGPT_API_TOKEN'));
    }

    public function testModerateComment()
    {
        $this->assertFalse($this->dataProvider->moderateComment('Очень обычный коммент, ничего страшного'));
        $this->assertTrue($this->dataProvider->moderateComment('Go cut your veins'));
    }

    public function testTuneAnswer()
    {
        $settingsList = $this->getSettingsList();
        $result = $this->dataProvider->tuneAnswer($settingsList);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Message::class, $result);
        $this->assertObjectHasProperty('role', $result);
        $this->assertObjectHasProperty('comment', $result);
        $this->assertTrue(str_contains($result->comment->text, $settingsList->getSettings()[0]->prompt));

    }
    public function testGenerateAnswer()
    {
        $message = new Comment('Дуже гарно хлопці! Робить музику ще');
        $this->dataProvider->setSettingList($this->getSettingsList());
        $answer = $this->dataProvider->generateAnswer($message);
        $this->assertInstanceOf(Answer::class, $answer);
        $this->assertNotEmpty($answer->text);
    }
}
