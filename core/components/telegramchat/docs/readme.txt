--------------------
TelegramChat
--------------------
Author: Sergei Peleskov <info@s1temaker.ru>
--------------------

1 Делаем группу
2 Включаем в группе Темы
3 Делаем бота @BotFather
4 Добавляем бота в группу админом
5 Для работы Telegram webhook требуется сертификат SSL
6 Телеграм шлет запросы на webhook с пустым reffer, возможно такой запрос будет блокироваться на хостинге, тогда на сайт не будут приходить ответы менеджера
7 В системных настройках нужно указать api_key для Бота, полученного при его создании
8 В системных настройках нужно указать chat ID
    - Устанавливаем статус группы: Публичная
    - Устанавливаем ИмяГруппы
    - Переходим по ссылке https://api.telegram.org/botBOT:TOKEN/getChat?chat_id=@ИмяГруппы
    - в ответ получим JSON где есть нужный нам ID
        {
            "ok": true,
            "result": {
                "id": -1000000000000,
                ...
                ]
            }
        }
    - Можно вернуть группе статус: Частная
9 Добавить стили 
    <link rel="stylesheet" href="[[++assets_url]]components/telegramchat/web/css/style.min.css">
10 Добавить скрипт
    <script src="[[++assets_url]]components/telegramchat/web/js/tgchat_script.min.js"></script>
11 Добавить в тег head вызов словаря
    {$_modx->lexicon->load('telegramchat:cust_default')}