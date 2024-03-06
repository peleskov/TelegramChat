<div id="Messenger">
    <div class="collapse mb-4" id="collapseMessenger">
        <div class="card">
            {'!tgChat'|snippet:[
                'snippet' => 'tgChat',
                'action' => 'message/getlist',
                'nameSupport' => 'tgchat_name_support'|lexicon,
                'roleSupport' => 'tgchat_role_support'|lexicon,
                'txtIntro' => 'tgchat_intro'|lexicon,
                'tplOut' => 'tgChat.messages.out',
                'tplRow' => 'tgChat.message.row',
            ]}
            <div class="card-footer">
                {'!AjaxForm'|snippet:[
                    'snippet' => 'tgChat',
                    'action' => 'message/create',
                    'nameSupport' => 'tgchat_name_support'|lexicon,
                    'nameClient' => 'tgchat_name_client'|lexicon,
                    'form' => 'tgChat.message.form',
                    'tplRow' => 'tgChat.message.row',
                ]}
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button class="btn btn-messenger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMessenger" data-toggle="collapse" data-target="#collapseMessenger" aria-expanded="true" aria-controls="collapseMessenger"></button>
    </div>
</div>
