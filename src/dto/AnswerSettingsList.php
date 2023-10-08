<?php

namespace dimuses\chatgpt\dto;

final class AnswerSettingsList
{

    /**
     * @var array<int,AnswerSetting>|AnswerSetting[]
     */
    protected array $settings = [];

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * @param AnswerSetting $answerSetting
     * @return void
     */
    public function addSetting(AnswerSetting $answerSetting): void
    {
        $this->settings[] = $answerSetting;
    }

}