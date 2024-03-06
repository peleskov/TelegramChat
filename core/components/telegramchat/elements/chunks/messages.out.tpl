<div class="card-header d-flex">
    <i class="ico support mr-3 me-3"></i>
    <div>
        <p class="name mb-1">{$nameSupport}</p>
        <p class="mb-0">{$roleSupport}</p>
    </div>
    <button type="button" class="close" data-toggle="collapse" data-target="#collapseMessenger" data-bs-toggle="collapse" data-bs-target="#collapseMessenger" aria-expanded="true"
        aria-controls="collapseMessenger"></button>
</div>
<div class="card-body">
    <div class="chat-wrapper scrollbar-inner" data-chat_key="{$tgchat_key}">
        {$wrapper}
    </div>
</div>