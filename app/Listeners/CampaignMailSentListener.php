<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use App\Models\Record;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CampaignMailSentListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $mail_id = $event->message->getId();
        $tag = $event->message->getHeaders()->get('X-Mailgun-Tag')->getFieldBody();
        $to = $event->message->getHeaders()->get('To')->getFieldBody();
//        Log::info("Tag: {$tag}, email: {$to}");
        $record = Record::where('report_id', $tag)->where('email', $to)->first();
//        Log::info("Record finded: {$record->id}");
        $record->mail_id = $mail_id;
        $record->queued = false;
        $record->sended = true;
        $record->save();
    }
}
