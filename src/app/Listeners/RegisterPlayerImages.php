<?php declare(strict_types=1);

namespace App\Listeners;

use App\Events\PlayerImagesRegisterRequested;
use App\UseCases\Admin\RegisterFlash;
use App\UseCases\Admin\RegisterPlayerImages as RegisterPlayerImagesUC;


class RegisterPlayerImages
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private RegisterFlash $registerFlash,
        private RegisterPlayerImagesUC $registerPlayerImages
    ) {
        //
    }

    /**
     * FlashId, FlashImageIdが保存されていないなら取得してから保存する
     * 
     * 選手の画像を取得して保存する
     */
    public function handle(PlayerImagesRegisterRequested $event): void
    {
        $this->registerFlash->execute($event->invalidApiPlayerIds);

        $this->registerPlayerImages->execute($event->invalidApiPlayerIds);
    }
}
