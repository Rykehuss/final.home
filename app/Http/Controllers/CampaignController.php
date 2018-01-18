<?php

namespace App\Http\Controllers;

use App\Mail\CampaignMail;
use App\Models\Campaign;
use App\Models\Report;
use App\Models\Record;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecordController;
use App\Http\Requests\CampaignRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CampaignController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Campaign::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $campaigns = Campaign::orderBy('id', 'asc')->owned()->get();
        return view('campaign.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('campaign.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CampaignRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request) {
        Campaign::create($request->all());
        return redirect()->route('campaign.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Campaign $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign) {
        return view('campaign.show', compact('campaign'));
    }

    /**
     * Display campaign before sending.
     *
     * @param  Campaign $campaign
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function preview(Campaign $campaign) {
        $this->authorize('view', $campaign);
        return view('campaign.preview', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Campaign $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign) {
        return view('campaign.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Campaign $campaign
     * @param  \App\Http\Requests\CampaignRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Campaign $campaign, CampaignRequest $request) {
        $campaign->update($request->all());
        return redirect()->route('campaign.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Campaign $campaign
     * @return \Illuminate\Http\Response
     * @throws
     */
    public function destroy(Campaign $campaign) {
        $campaign->delete();
        return redirect()->route('campaign.index');
    }

    /**
     * Send campaign template via e-mail.
     *
     * @param  Campaign $campaign
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function send(Campaign $campaign) {
        $this->authorize('send', $campaign);

        $mailsInBatch = config('custom.mails_in_batch');
        $batchDelay = config('custom.batch_delay');
        $mailsPerDay = config('custom.mails_per_day');

        $subscribers = $campaign->bunch->subscribers;
        $mailsSendedToday = Record::whereDate('created_at', '=', date('Y-m-d'))->get()->count();
        $mailsPerDayLeft = $mailsPerDay - $mailsSendedToday;

        if ($mailsPerDayLeft < $subscribers->count()) {
            Session::flash('error', "Campaign can not be sent. Campain contain {$subscribers->count()} subscribers, but You may send only {$mailsPerDayLeft} mails today. (Daily limit: {$mailsPerDay} mails");
            return redirect()->route('campaign.index');
        }
        else {
            $report = ReportController::createNew($campaign);

            for ($i = 0; $i < $subscribers->count(); $i++) {
                $subscriber = $subscribers[$i];
                $delay = intdiv($i, $mailsInBatch) * $batchDelay;

                $mail = new CampaignMail($campaign, $subscriber, $report);
                $mail->onConnection('database')->onQueue('emails')->delay(now()->addSeconds($delay));

                RecordController::createNew($mail);

                Mail::to($subscriber->email)->queue($mail);
            }
            $mailsPerDayLeft -= $subscribers->count();
            Session::flash('status', "Campaign has been sent. You may send {$mailsPerDayLeft} mails more today. (Daily limit: {$mailsPerDay} mails)");
            return redirect()->route('campaign.index');
        }
    }

    public function mailInfo() {
        $domain = config("mailgun.domain");
        $result = \Bogardo\Mailgun\Facades\Mailgun::api()->get($domain."/events", [
            'limit' => 50,
//            'tags' => '38',
//            'to' => 'dmtrggl@gmail.com',
//            'event' => 'opened',
            'message-id' => 'b6d1014937ca07a01dc8ae792232dbbe@swift.generated',
        ]);
//        $last = $result->http_response_body->paging->next;
//        $result = \Bogardo\Mailgun\Facades\Mailgun::api()->get($last);
        dd($result);
    }
}

//php artisan queue:work database --queue=emails