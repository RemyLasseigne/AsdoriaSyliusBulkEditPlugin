<?php

declare(strict_types=1);

/*
 * This file is part of the Asdoria Package.
 *
 * (c) Asdoria .
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asdoria\SyliusBulkEditPlugin\EventListener;

use Asdoria\SyliusBulkEditPlugin\Message\BulkEditNotificationInterface;
use Asdoria\SyliusBulkEditPlugin\Traits\EntityManagerTrait;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;

/**
 * Class WorkerMessageListener.
 * @package Asdoria\SyliusBulkEditPlugin\EventListener
 *
 * @author  Philippe Vesin <pve.asdoria@gmail.com>
 */
class WorkerMessageListener
{
    use EntityManagerTrait;

    /**
     * @param WorkerMessageReceivedEvent $event
     */
    public function received(WorkerMessageReceivedEvent $event): void
    {
        $this->processChangeState($event, 'received');
    }

    /**
     * @param WorkerMessageHandledEvent $event
     *
     * @return void
     */
    public function handled(WorkerMessageHandledEvent $event): void
    {
        $this->processChangeState($event, 'success');
    }

    /**
     * @param WorkerMessageFailedEvent $event
     */
    public function failed(WorkerMessageFailedEvent $event): void
    {
        $this->processChangeState(
            $event,
            'error',
            $event->getThrowable()->getMessage()
        );
    }

    /**
     * @param AbstractWorkerMessageEvent $event
     * @param string                     $newState
     * @param string|null                $msg
     *
     * @return void
     */
    protected function processChangeState(AbstractWorkerMessageEvent $event, string $newState, ?string $msg = null): void
    {
        $envelope = $event->getEnvelope();
        $message  = $envelope->getMessage();

        if (!$message instanceof BulkEditNotificationInterface) return;

        //TODO
    }
}
