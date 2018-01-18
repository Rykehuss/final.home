<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Campaign;
use App\Models\Report;

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
     * @param Report $report
     * @return void
     */
    public function __construct(Campaign $campaign, Subscriber $subscriber, Report $report = null)
    {
        if ($report) {
            $this->campaign = $report->campaign;
            $this->tag = $report->id;

        }
        else {
            $this->campaign = $campaign;
            $this->tag = 0;
        }
        $this->subscriber = $subscriber;

        $this->from($this->campaign->updatedBy->email, $this->campaign->updatedBy->name);
        $this->subject($this->campaign->name);
    }

    /**
     * Build the message.
     *
     * @return CampaignMail
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
                'tag' => $this->tag,
            ]);

        return $this;
    }
}
