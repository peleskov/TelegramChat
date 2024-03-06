<form class="d-flex">
    <input type="hidden" name="key" value="{$.session.tgchat_key}">
    <input type="hidden" name="name" value="{$nameClient}">
    <input type="text" class="form-control mr-3 me-3" name="text" placeholder="{'tgchat_plh_message'|lexicon}">
    <button class="btn btn-send"></button>
</form>
