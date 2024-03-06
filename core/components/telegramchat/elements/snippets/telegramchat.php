<?php
require_once MODX_CORE_PATH . 'components/telegramchat/Telegram/api.php';

/** @var modX $modx */
/** @var array $scriptProperties */
/** @var tgChat $tgChat */

$fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
$path = $modx->getOption('pdofetch_class_path', null, MODX_CORE_PATH . 'components/pdotools/model/', true);
if ($pdoClass = $modx->loadClass($fqn, $path, false, true)) {
    $pdoFetch = new $pdoClass($modx, $scriptProperties);
} else {
    return false;
}
$pdoFetch->addTime('pdoTools loaded');

$tgChat = $modx->getService('TelegramChat', 'TelegramChat', MODX_CORE_PATH . 'components/telegramchat/model/', $scriptProperties);
if (!$tgChat) {
    return 'Could not load TelegramChat class!';
}
$tgchat_key = session_id();
if (!isset($_SESSION['tgchat_key']) || $_SESSION['tgchat_key'] != $tgchat_key) {
    $_SESSION['tgchat_key'] = $tgchat_key;
}
$modx->lexicon->load('telegramchat:cust_default');
switch ($action) {
    case 'message/getlatest':
        $outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
        $tgchat_key = $modx->getOption('key', $scriptProperties, '');
        $count = $modx->getOption('count', $scriptProperties, 0);
        $tplRow = $modx->getOption('tplRow', $scriptProperties, '');

        $q = $modx->newQuery('TelegramChatItem');
        $where = [
            'key' => $tgchat_key,
            'support' => 1,
        ];
        $q->limit(100, $count);
        $q->where($where);
        $q->sortby('created', 'ASC');
        $q->prepare();
        //$modx->log(1, $q->toSQL());
        $output = '';
        if ($messages = $modx->getCollection('TelegramChatItem', $q)) {
            foreach ($messages as $message) {
                $idx += 1;
                $item = array_merge($message->toArray(), $scriptProperties);
                $items[] = empty($tplRow)
                    ? '<pre>' . $pdoFetch->getChunk('', $item) . '</pre>'
                    : $pdoFetch->getChunk($tplRow, $item);
            }
            $output = implode($outputSeparator, $items);
        }
        return $output;
        break;
    case 'message/getlist':
        $outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
        $tplOut = $modx->getOption('tplOut', $scriptProperties, '');
        $nameSupport = $modx->getOption('nameSupport', $scriptProperties, 'Support');
        $txtIntro = $modx->getOption('txtIntro', $scriptProperties, 'Welcome');
        $tplRow = $modx->getOption('tplRow', $scriptProperties, '');
        $q = $modx->newQuery('TelegramChatItem');
        $where = [
            'key' => $tgchat_key,
        ];
        $q->where($where);
        $q->sortby('created', 'ASC');
        $q->prepare();
        $items = [];
        $idx = 0;
        $messages = $modx->getCollection('TelegramChatItem', $q);
        if (count($messages) == 0) {
            $msg_intro = $modx->newObject('TelegramChatItem');
            $msg_intro->set('key', $tgchat_key);
            $msg_intro->set('created', time());
            $msg_intro->set('support', 1);
            $msg_intro->set('name', $nameSupport);
            $msg_intro->set('text', $txtIntro);
            $msg_intro->save();
            $messages = $modx->getCollection('TelegramChatItem', $q);
        }
        foreach ($messages as $message) {
            $idx += 1;
            $item = array_merge($message->toArray(), $scriptProperties);
            $items[] = empty($tplRow)
                ? '<pre>' . $pdoFetch->getChunk('', $item) . '</pre>'
                : $pdoFetch->getChunk($tplRow, $item);
        }
        $output = array_merge(array(
            'tgchat_key' => $tgchat_key,
            'wrapper' => implode($outputSeparator, $items)
        ), $scriptProperties);
        $output = empty($tplOut)
            ? '<pre>' . $pdoFetch->getChunk('', $items) . '</pre>'
            : $pdoFetch->getChunk($tplOut, $output);
        return $output;
        break;
    case 'message/create':
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $nameSupport = $modx->getOption('nameSupport', $scriptProperties, 'Support');
            $telegram = new Telegram($modx);
            $webhook_url = 'https://' . MODX_HTTP_HOST . '/assets/components/telegramchat/webhook.php';
            $webhook_info = $telegram->send('getWebhookInfo');
            if ($webhook_info['url'] != $webhook_url) {
                $telegram->send('setWebhook', ['url' => $webhook_url]);
            }

            // проверим что ключ чата совпадает
            if ($_POST['key'] != $tgchat_key) {
                return $AjaxForm->error('', array('service' => 'tgchat', 'result' => false, 'message' => 'Invalid chat key!'));
            }

            if (!$chat = $modx->getObject('TelegramChats', ['key' => $tgchat_key])) {
                // чата еще нет, создадим новый
                $chat = $modx->newObject('TelegramChats', ['key' => $tgchat_key]);
                if ($chat->save()) {
                    $res = $telegram->send('createForumTopic', [
                        'name' => "Клиент с сайта: {$modx->getOption('site_url')}",
                    ]);
                    if ($res['ok'] && $res['result']['message_thread_id'] > 0) {
                        $chat->set('message_thread_id', $res['result']['message_thread_id']);
                        if (!$chat->save()) {
                            return $AjaxForm->error('', array('service' => 'tgchat', 'result' => false, 'message' => 'Can not save chat!'));
                        }
                    } else {
                        return $AjaxForm->error('', array('service' => 'tgchat', 'result' => false, 'message' => 'createForumTopi -> Error response from Telegram!', 'res' => $res));
                    }
                } else {
                    return $AjaxForm->error('', array('service' => 'tgchat', 'result' => false, 'message' => 'Can not save chat!'));
                }
            }
            $message_thread_id = $chat->get('message_thread_id');
            if ($message_thread_id > 0) {
                $message_params = [
                    'text' => strip_tags($_POST['text']),
                    'message_thread_id' => $chat->get('message_thread_id'),
                    'parse_mode' => 'Markdown',
                ];

                $response = $telegram->send('sendMessage', $message_params);
                // Запишем новое сообщение в базу
                if ($msg = $modx->newObject('TelegramChatItem')) {
                    $msg->set('key', $tgchat_key);
                    $msg->set('created', time());
                    $msg->set('support', 0);
                    $msg->set('name', strip_tags($_POST['name']));
                    $msg->set('text', strip_tags($_POST['text']));
                } else {
                    return $AjaxForm->error('', array('service' => 'tgchat', 'result' => false, 'message' => 'Can not create a message!'));
                }

                if ($msg->save()) {
                    $item = array_merge($msg->toArray(), $scriptProperties);
                    $output = empty($tplRow)
                        ? '<pre>' . $pdoFetch->getChunk('', $item) . '</pre>'
                        : $pdoFetch->getChunk($tplRow, $item);
                    return $AjaxForm->success('', array('service' => 'tgchat', 'result' => true, 'key' => $tgchat_key, 'msg' => $output));
                } else {
                    return $AjaxForm->error('', array('service' => 'tgchat', 'result' => false, 'message' => 'Can not save a message!'));
                }
            } else {
                return $AjaxForm->error('', array('service' => 'tgchat', 'result' => false, 'message' => 'Message thread id invalid!'));
            }
        }
        break;
}
return;
