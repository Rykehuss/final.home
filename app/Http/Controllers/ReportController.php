<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Campaign;
use App\Models\Record;
use App\Models\Subscriber;
use App\Http\Requests\UnsubscribeRequest;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::orderBy('id', 'desc')->owned()->get();

        return view('report.index', compact('reports'));
    }

    private function updateReport(Report $report) {
        $records = Record::where('report_id', $report->id)->get();
        $domain = config("mailgun.domain");
        foreach ($records as $record) {
            if ($record->sended) {
                $result = \Bogardo\Mailgun\Facades\Mailgun::api()->get($domain . "/events", [
                    'message-id' => $record->mail_id,
                ]);
                $items = $result->http_response_body->items;
                foreach ($items as $item) {
                    $status = $item->event;
                    switch ($status) {
                        case 'accepted':
                            $record->accepted = true;
                            break;
                        case 'delivered':
                            $record->delivered = true;
                            break;
                        case 'failed':
                            $record->failed = true;
                            break;
                        case 'opened':
                            $record->opened = true;
                            break;
                    }
                }
                $record->save();
            }
        }
    }

    /**
     * Create a new report.
     *
     * @return \Illuminate\Http\Response
     */
    public static function createNew(Campaign $campaign)
    {
        $report = new Report;
        $report->campaign_id = $campaign->id;
        $report->save();
        return $report;
    }

    /**
     * Display the specified resource.
     *
     * @param  Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $this->authorize('view', $report);

        $this->updateReport($report);

        $records = Record::where('report_id', $report->id)->get();

        return view('report.show', compact('report', 'records'));
    }

    public static function unsubscribe(Report $report, Subscriber $subscriber) {
        $campaign = $report->campaign;
        if ($campaign->bunch->subscribers->contains($subscriber)) {
            return view('report.unsubscribe_reason', compact('report', 'subscriber'));
        } else {
            return view('bunch.unsubscribe_unsuccessfully', compact('campaign', 'subscriber'));
        }
    }

    public static function unsubscribeStore(UnsubscribeRequest $request, Report $report, Subscriber $subscriber) {
        $reason = $request->input('reason');

        $record = Record::where('report_id', $report->id)->where('email', $subscriber->email)->get()->first();
        $record->unsubscribed = true;
        $record->unsubscribe_reason = $reason;
        $record->save();

        $campaign = $report->campaign;
        $campaign->bunch->subscribers()->detach($subscriber->id);
        return view('bunch.unsubscribe_successfully', compact('campaign', 'subscriber'));

    }
}
