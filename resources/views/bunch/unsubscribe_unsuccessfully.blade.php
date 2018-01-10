@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="alert alert-danger">
                            <h4>Error in unsubscribe request.</h4><br>
                            Subscriber <strong>{{$subscriber->name}}</strong>
                            not belongs to <strong>{{$campaign->bunch->name}}</strong> bunch.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection