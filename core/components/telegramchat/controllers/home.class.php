<?php

/**
 * The home manager controller for TelegramChat.
 *
 */
class TelegramChatHomeManagerController extends modExtraManagerController
{
    /** @var TelegramChat $TelegramChat */
    public $TelegramChat;


    /**
     *
     */
    public function initialize()
    {
        $this->TelegramChat = $this->modx->getService('TelegramChat', 'TelegramChat', MODX_CORE_PATH . 'components/telegramchat/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['telegramchat:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('telegramchat');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->TelegramChat->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->TelegramChat->config['jsUrl'] . 'mgr/telegramchat.js');
        $this->addJavascript($this->TelegramChat->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->TelegramChat->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->TelegramChat->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->TelegramChat->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->TelegramChat->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->TelegramChat->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        TelegramChat.config = ' . json_encode($this->TelegramChat->config) . ';
        TelegramChat.config.connector_url = "' . $this->TelegramChat->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "telegramchat-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="telegramchat-panel-home-div"></div>';

        return '';
    }
}