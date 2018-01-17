<?php

namespace App\Http\Controllers;

use App\Mail\CampaignMail;
use App\Models\Campaign;
use App\Models\Report;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecordController;
use App\Http\Requests\CampaignRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request) {
        Campaign::create($request->all());
        return redirect()->route('campaign.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign) {
        return view('campaign.show', compact('campaign'));
    }

    /**
     * Display campaign before sending.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function preview(Campaign $campaign) {
        $this->authorize('view', $campaign);
        return view('campaign.preview', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign) {
        return view('campaign.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Campaign $campaign, CampaignRequest $request) {
        $campaign->update($request->all());
        return redirect()->route('campaign.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign) {
        $campaign->delete();
        return redirect()->route('campaign.index');
    }

    /**
     * Send campaign template via e-mail.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function send(Campaign $campaign, Request $request) {
        $mailsInBatch = config('custom.mails_in_batch');
        $batchDelay = config('custom.batch_delay');

        $this->authorize('send', $campaign);

        $report = ReportController::createNew($campaign);

        for ($i = 0; $i < $campaign->bunch->subscribers->count(); $i++) {
            $subscriber = $campaign->bunch->subscribers[$i];
            $delay = intdiv($i, $mailsInBatch) * $batchDelay;

            $mail = new CampaignMail($campaign, $subscriber, $report->id);
            $mail->onConnection('database')->onQueue('emails')->delay(now()->addSeconds($delay));

            RecordController::createNew($mail);

            Mail::to($subscriber->email)->queue($mail);
        }
        Session::flash('status', 'Campaign has been sent');
        return redirect()->route('campaign.index');
    }

    public function mailInfo() {
        $domain = config("mailgun.domain");
        $result = \Bogardo\Mailgun\Facades\Mailgun::api()->get($domain."/events", [
            'limit' => 300,
            'tags' => 'test2_tag',
        ]);
//        $last = $result->http_response_body->paging->next;
//        $result = \Bogardo\Mailgun\Facades\Mailgun::api()->get($last);
        dd($result);
    }
}

//php artisan queue:work database --queue=emails