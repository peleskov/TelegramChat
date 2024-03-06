<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/TelegramChat/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/telegramchat')) {
            $cache->deleteTree(
                $dev . 'assets/components/telegramchat/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/telegramchat/', $dev . 'assets/components/telegramchat');
        }
        if (!is_link($dev . 'core/components/telegramchat')) {
            $cache->deleteTree(
                $dev . 'core/components/telegramchat/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/telegramchat/', $dev . 'core/components/telegramchat');
        }
    }
}

return true;