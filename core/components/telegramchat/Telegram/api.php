<?php

class Telegram
{
    private $modx;

    public function __construct($modx)
    {
        $this->modx =& $modx;
        $this->apiKey = $modx->getOption('telegramchat_bot_api_key');
        $this->chatID = $modx->getOption('telegramchat_group_chat_id');
        $this->botID = $modx->getOption('telegramchat_bot_id');
    }
    
    public function getWebhookInfo($method, $data)
    {   

    }
    public function send($method, $data=[])
    {   
        if(!in_array($method, ['getWebhookInfo', 'setWebhook'])) {
            $data['chat_id'] = $this->chatID;
        }
        $url = "https://api.telegram.org/bot{$this->apiKey}/{$method}";
        if(!empty($data)){
            $query = http_build_query($data);
            $url = "$url?{$query}";
        }
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)){
            $out = ['ok' => false];
        } else {
            $out = json_decode($response, 1);
        }
        curl_close($ch);        
        return $out;
    }
}
