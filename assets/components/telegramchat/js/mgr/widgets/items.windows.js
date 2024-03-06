TelegramChat.window.CreateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'telegramchat-item-window-create';
    }
    Ext.applyIf(config, {
        title: _('telegramchat_item_create'),
        width: 550,
        autoHeight: true,
        url: TelegramChat.config.connector_url,
        action: 'mgr/item/create',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    TelegramChat.window.CreateItem.superclass.constructor.call(this, config);
};
Ext.extend(TelegramChat.window.CreateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'textfield',
            fieldLabel: _('telegramchat_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('telegramchat_item_description'),
            name: 'description',
            id: config.id + '-description',
            height: 150,
            anchor: '99%'
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('telegramchat_item_active'),
            name: 'active',
            id: config.id + '-active',
            checked: true,
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('telegramchat-item-window-create', TelegramChat.window.CreateItem);


TelegramChat.window.UpdateItem = function (config) {
    config = config || {};
    if (!config.id) {
        config.id = 'telegramchat-item-window-update';
    }
    Ext.applyIf(config, {
        title: _('telegramchat_item_update'),
        width: 550,
        autoHeight: true,
        url: TelegramChat.config.connector_url,
        action: 'mgr/item/update',
        fields: this.getFields(config),
        keys: [{
            key: Ext.EventObject.ENTER, shift: true, fn: function () {
                this.submit()
            }, scope: this
        }]
    });
    TelegramChat.window.UpdateItem.superclass.constructor.call(this, config);
};
Ext.extend(TelegramChat.window.UpdateItem, MODx.Window, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id',
            id: config.id + '-id',
        }, {
            xtype: 'textfield',
            fieldLabel: _('telegramchat_item_name'),
            name: 'name',
            id: config.id + '-name',
            anchor: '99%',
            allowBlank: false,
        }, {
            xtype: 'textarea',
            fieldLabel: _('telegramchat_item_description'),
            name: 'description',
            id: config.id + '-description',
            anchor: '99%',
            height: 150,
        }, {
            xtype: 'xcheckbox',
            boxLabel: _('telegramchat_item_active'),
            name: 'active',
            id: config.id + '-active',
        }];
    },

    loadDropZones: function () {
    }

});
Ext.reg('telegramchat-item-window-update', TelegramChat.window.UpdateItem);