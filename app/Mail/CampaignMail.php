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

    protected $campaign;
    protected $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, Subscriber $subscriber)
    {
        $this->campaign = $campaign;
        $this->subscriber = $subscriber;

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
        return $this->view('emails.campaign_mail')
            ->with([
                'campaign' => $this->campaign,
                'subscriber' => $this->subscriber,
            ]);
    }
}
