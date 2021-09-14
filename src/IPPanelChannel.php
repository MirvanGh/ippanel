<?php

namespace Mirvan\IPPanel;

use Illuminate\Notifications\Notification;
use IPPanel\Errors\Error;
use IPPanel\Errors\HttpException;
use Mirvan\IPPanel\Exceptions\CouldNotSendNotification;

class IPPanelChannel
{
    /** @var IPPanelClient */
    protected $client;

    /**
     * @param  IPPanelClient  $client
     */
    public function __construct(IPPanel $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws \NotificationChannels\IPPanel\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toIPPanel($notifiable);

        if (is_string($message)) $message = IPPanelMessage::create($message);

        if (!($recipient = $notifiable->routeNotificationFor('IPPanel')) && empty($message->getReference()) )
            throw CouldNotSendNotification::mustSetReference();
        else
            $recipient = is_array($recipient) ? $recipient : [$recipient];

        if($message->getOriginator() == null){
            if (method_exists($notifiable, 'ippanelOriginator'))
                $message->originator($notifiable->ippanelOriginator($notification));
            else
                throw CouldNotSendNotification::mustSetOriginator();
        }

        try {
            if ($message->type() == 'message')
                $bulkID = $this->client->send(
                    $message->getOriginator(),
                    $message->getReference() ? $message->getReference() : $recipient,
                    $message->getBody()
                );
            elseif ($message->type() == 'pattern')
                $bulkID = $this->client->sendPattern(
                    $message->getPattern(),
                    $message->getOriginator(),
                    $message->getReference()[0] ?? $recipient[0],
                    $message->getVariables(),
                );
        } catch (Error $e) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($e->unwrap());
        } catch (HttpException $e) {
            throw CouldNotSendNotification::httpClientRespondedWithAnError($e->getMessage());
        }
    }
}
