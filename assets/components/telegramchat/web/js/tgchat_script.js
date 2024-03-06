$.getScript('assets/components/telegramchat/libs/scrollbar/jquery.scrollbar.min.js', function(){
    console.log('Scrollbar script loaded!!!')
    if ($('.scrollbar-inner').length > 0) {
        $('.scrollbar-inner').scrollbar();
        $('[data-chat_key]').scrollTop($('[data-chat_key]')[0].scrollHeight);
    }    
});

(function () {

    const result = {

        init: function () {

            this.eventSubscription()
            this.updateChat()
        },

        eventSubscription: function () {

            $(document).on('af_complete', $.proxy(this.eventAfComplete, this))
        },

        eventAfComplete: function (event, response) {
            if ('service' in response.data && response.data.service == 'tgchat') {
                this.cleanDOM(response)
                this.offLibraries(response)
                this.getService(response)
            }
        },

        cleanDOM: function (response) {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        },

        offLibraries: function (response) {

            response.message = ''

        },

        getService: function (response) {
            if (response.data.result && response.data.msg != '' && response.data.key != '') {
                let chat_wrapper = $('[data-chat_key="' + response.data.key + '"]')
                chat_wrapper.append(response.data.msg)
                chat_wrapper.scrollTop(chat_wrapper[0].scrollHeight);
            }
        },
        updateChat: function () {
            chat_wrapper = $('[data-chat_key]')
            let chat_key = chat_wrapper.data('chat_key')
            setInterval(() => {
                let count = chat_wrapper.find('.support').length
                $.post( "assets/components/telegramchat/webhook.php", { key: chat_key, count: count } )
                    .done(function( res ) {
                        let response = jQuery.parseJSON(res)
                        if (response.data.result && response.data.msgs != '' && response.data.key != '') {
                            let chat_wrapper = $('[data-chat_key="' + response.data.key + '"]')
                            chat_wrapper.append(response.data.msgs)
                            chat_wrapper.scrollTop(chat_wrapper[0].scrollHeight);
                        }                        
                });
            }, 5000)
        },
    }
    result.init()
})()
