<?php
// Подключаем
define('MODX_API_MODE', true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/index.php');

$tgChat = $modx->getService('TelegramChat', 'TelegramChat', MODX_CORE_PATH . 'components/telegramchat/model/');
if (!$tgChat) {
    $modx->log(1, 'Could not load TelegramChat class!');
}

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
//$modx->log(1, print_r($input, true));
$modx->lexicon->load('telegramchat:cust_default');
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    // обработаем запросы от сайта
    if (isset($_POST['count'])) {
        $out = [
            'data' => [
                'result' => true,
                'key' => $_POST['key'],
                'msgs' => $modx->runSnippet('tgChat', [
                    'key' => $_POST['key'],
                    'action' => 'message/getlatest',
                    'count' => (int) $_POST['count'],
                    'tplRow' => 'tgChat.message.row',
                ]),
            ]
        ];
        die(json_encode($out, true));
    }
} else {
    // обработаем запросы от telegram
    if (isset($input['message']['message_thread_id']) && $input['message']['message_thread_id'] > 0 && !empty($input['message']['text'])) {
        if ($chat = $modx->getObject('TelegramChats', ['message_thread_id' => $input['message']['message_thread_id']])) {
            // Запишем новое сообщение в базу
            if ($msg = $modx->newObject('TelegramChatItem')) {
                $msg->set('key', $chat->get('key'));
                $msg->set('created', time());
                $msg->set('support', 1);
                $msg->set('name', $modx->lexicon('tgchat_name_support'));
                $msg->set('text', $input['message']['text']);
                if (!$msg->save()) {
                    $modx->log(1, 'Cannot save manager answer!');
                }
            } else {
                return $modx->log(1, 'Can not create a message!');
            }
        } else {
            $modx->log(1, 'Cannot find chat!');
        }
    } else {
        $modx->log(1, 'Message thread ID invalid!');
    }
}
