@extends('layouts.panel')
@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2" href="{{route('report.index')}}">
                <i class="fa fa-backward" aria-hidden="true"></i> Back
            </a>
            <div class="centered-child col-md-9 col-sm-7 col-xs-6">Report: <b>{{$report->campaign->name}}|{{$report->created_at}}</b></div>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-responsive">
            <tr>
                <th width="25%">Attribute</th>
                <th width="75%">Value</th>
            </tr>
            @foreach ($report->getAttributes() as $attribute => $value)
                <tr>
                    <td>{{$attribute}}</td>
                    <td>{{$value}}</td>
                </tr>
            @endforeach
        </table>

        <div><strong>Records:</strong></div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th width="5%">Id</th>
                <th width="30%">Recipient</th>
                <th>Status</th>
            </tr>
            @foreach ($records as $record)
                <?php
                    $status = "Error";
                    if ($record->failed) {
                        $status = "Failed";
                    }
                    else if ($record->delivered) {
                        $status = "Delivered";
                    }
                    else if ($record->accepted) {
                        $status = "Accepted";
                    }
                    else if ($record->sended) {
                        $status = "Sended";
                    }
                    else if ($record->queued) {
                        $status = "Queued";
                    }
                    if ($status != "Error") {
                        if ($record->opened) {
                            $status .= " | Opened";
                        }
                        if ($record->unsubscribed) {
                            $status .= " | Unsubscribed";
                        }
                    }
                ?>
                <tr>
                    <td>{{$record->id}}</td>
                    <td>{{$record->email}}</td>
                    <td>{{$status}}</td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection