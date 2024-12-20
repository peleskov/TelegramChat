TelegramChat.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'telegramchat-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('telegramchat') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('telegramchat_items'),
                layout: 'anchor',
                items: [{
                    html: _('telegramchat_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'telegramchat-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    TelegramChat.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(TelegramChat.panel.Home, MODx.Panel);
Ext.reg('telegramchat-panel-home', TelegramChat.panel.Home);
