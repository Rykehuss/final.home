<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Mail\CampaignMail;

class RecordController extends Controller
{
    /**
     * Create a new record.
     *
     * @param CampaignMail $mail
     * @return \App\Models\Record
     */
    public static function createNew(CampaignMail $mail)
    {
        $record = new Record;
        $record->report_id = $mail->tag;
        $record->email = $mail->subscriber->email;
        $record->queued = true;
        $record->save();
        return $record;
    }
}
