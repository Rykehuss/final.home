@extends('layouts.panel')

@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2" href="{{route('campaign.index')}}">
                <i class="fa fa-backward" aria-hidden="true"></i> Back
            </a>
            <div class="centered-child col-md-9 col-sm-7 col-xs-6">Preview campaign: <b>{{$campaign->name}}</b></div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <div class="pull-right">
                    {{Form::open(['class' => 'confirm-delete', 'route' => ['campaign.destroy', $campaign], 'method' => 'DELETE'])}}
                    {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <table class="table table-bordered table-responsive">
            <tbody>
            <tr>
                <td>Subject</td>
                <td>{{$campaign->name}}</td>
            </tr>
            <tr>
                <td>To</td>
                <td>
                    <?php
                        $subscribers = $campaign->bunch->subscribers;
                        if ($subscribers) {
                            $count = $subscribers->count();
                            $total = $count;
                            $max = 200;
                            if ($count > $max) {
                                $count = $max;
                                $shrinked = true;
                            }
                            else {
                                $shrinked = false;
                            }
                            for ($i = 0; $i < $count; $i++) {
                                echo $subscribers[$i]->email;
                                if ($i != $count - 1) {
                                    echo ", ";
                                }
                            }
                            if ($shrinked) {
                                echo "...";
                            }
                            echo "  ({$total} total)";
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>From</td>
                <td>{{$campaign->updatedBy->email.' ('.$campaign->updatedBy->name.')'}}</td>
            </tr>
            <tr>
                <td>Message</td>
                <td>
                    <iframe srcdoc="{{$campaign->template->content}}" height="300" width="100%">
                        Your browser doesn't support iFrames
                    </iframe>
                    <br>
                    @if ($campaign->bunch->subscribers->count())
                    {{ link_to_route('campaign_mail_preview', 'Show as Mail', [$campaign, $campaign->bunch->subscribers[0]], ['class' => 'btn btn-success btn-md']) }}
                    @else
                    If you want preview mail as HTML-page add at least 1 subscriber to bunch.
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

        {!! Form::model($campaign, ['route' => ['campaign.send', $campaign], 'method' => 'GET', 'class' => 'confirm-send']) !!}
            <div class="form-group">
                {!! Form::button('Send', ['type' => 'submit', 'class' => 'btn btn-success btn-md']) !!}
            </div>
        {!! Form::close() !!}

    </div>

    @include('layouts.validation_errors')

@endsection