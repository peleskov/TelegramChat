TelegramChat.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'telegramchat-panel-home',
            renderTo: 'telegramchat-panel-home-div'
        }]
    });
    TelegramChat.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(TelegramChat.page.Home, MODx.Component);
Ext.reg('telegramchat-page-home', TelegramChat.page.Home);