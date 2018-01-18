@extends('layouts.panel')
@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2" href="{{route('report.index')}}">
                <i class="fa fa-backward" aria-hidden="true"></i> Back
            </a>
            <div class="centered-child col-md-9 col-sm-7 col-xs-6">Report: <b>{{$report->campaign->name}} | {{$report->created_at}}</b></div>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-responsive">
            <tr>
                <th><strong>Statistics</strong></th>
                <th><strong>Attributes</strong></th>
            </tr>
            <tr>
                <td width="50%">
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th width="75%">Status</th>
                            <th width="25%">Percents</th>
                        </tr>
                        <?php
                            $total = $records->count();
                            $queued = $records->where('queued', 1)->count();
                            $sended = $records->where('sended', 1)->count();
                            $accepted = $records->where('accepted', 1)->count();
                            $delivered = $records->where('delivered', 1)->count();
                            $failed = $records->where('failed', 1)->count();
                            $opened = $records->where('opened', 1)->count();
                            $unsubscribed = $records->where('unsubscribed', 1)->count();
                        ?>
                        <tr>
                            <td>Queued</td>
                            <td>{{$queued/$total*100}}</td>
                        </tr>
                        <tr>
                            <td>Sended</td>
                            <td>{{$sended/$total*100}}</td>
                        </tr>
                        <tr>
                            <td>Accepted</td>
                            <td>{{$accepted/$total*100}}</td>
                        </tr>
                        <tr>
                            <td>Delivered</td>
                            <td>{{$delivered/$total*100}}</td>
                        </tr>
                        <tr>
                            <td>Failed</td>
                            <td>{{$failed/$total*100}}</td>
                        </tr>
                        <tr>
                            <td>Opened</td>
                            <td>{{$opened/$total*100}}</td>
                        </tr>
                        <tr>
                            <td>Unsubscribed</td>
                            <td>{{$unsubscribed/$total*100}}</td>
                        </tr>
                    </table>
                </td>
                <td>
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
                </td>
            </tr>
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
                    <td>
                        {{$status}}
                        @if($record->unsubscribed)
                            <button onclick='alert("{{$record->unsubscribe_reason}}")' class="btn btn-info pull-right">Unsubscribe reason</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

@endsection