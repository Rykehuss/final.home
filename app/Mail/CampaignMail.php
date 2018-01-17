<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Campaign;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    public $subscriber;
    public $tag;

    /**
     * Create a new message instance.
     *
     * @param Campaign $campaign
     * @param Subscriber $subscriber
     * @param string $tag
     * @return void
     */
    public function __construct(Campaign $campaign, Subscriber $subscriber, $tag = 0)
    {
        $this->campaign = $campaign;
        $this->subscriber = $subscriber;
        $this->tag = $tag;

        $this->from($this->campaign->updatedBy->email, $this->campaign->updatedBy->name);
        $this->subject($this->campaign->name);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader('X-Mailgun-Tag', $this->tag);
        });

        $this->view('emails.campaign_mail')
            ->with([
                'campaign' => $this->campaign,
                'subscriber' => $this->subscriber,
            ]);

        return $this;
    }
}
