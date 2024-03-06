<?php

class TelegramChatItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'TelegramChatItem';
    public $classKey = 'TelegramChatItem';
    public $languageTopics = ['telegramchat'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('telegramchat_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('telegramchat_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'TelegramChatItemCreateProcessor';