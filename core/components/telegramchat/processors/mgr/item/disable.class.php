<?php

class TelegramChatItemDisableProcessor extends modObjectProcessor
{
    public $objectType = 'TelegramChatItem';
    public $classKey = 'TelegramChatItem';
    public $languageTopics = ['telegramchat'];
    //public $permission = 'save';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('telegramchat_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var TelegramChatItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('telegramchat_item_err_nf'));
            }

            $object->set('active', false);
            $object->save();
        }

        return $this->success();
    }

}

return 'TelegramChatItemDisableProcessor';
