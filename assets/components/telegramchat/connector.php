<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var TelegramChat $TelegramChat */
$TelegramChat = $modx->getService('TelegramChat', 'TelegramChat', MODX_CORE_PATH . 'components/telegramchat/model/');
$modx->lexicon->load('telegramchat:default');

// handle request
$corePath = $modx->getOption('telegramchat_core_path', null, $modx->getOption('core_path') . 'components/telegramchat/');
$path = $modx->getOption('processorsPath', $TelegramChat->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);