var TelegramChat = function (config) {
    config = config || {};
    TelegramChat.superclass.constructor.call(this, config);
};
Ext.extend(TelegramChat, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('telegramchat', TelegramChat);

TelegramChat = new TelegramChat();