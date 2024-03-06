<div class="message {$support != 0? 'support':''} mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <p class="name mb-0">{$name}</p>
        <p class="date mb-0">{$created|date_format:'%H:%M'}</p>
    </div>
    <div class="text">{$text}</div>
</div>
<div class="clearfix"></div>