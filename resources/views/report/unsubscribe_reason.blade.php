@extends('layouts.panel')
@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <div class="centered-child col-md-11 col-sm-10 col-xs-10"><b>Unsubscribe Reason</b></div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['route' => ['report.unsubscribeStore', $report, $subscriber]]) !!}
        <div class="form-group">
            {!!Form::label('reason', 'Enter while You want unsubscribe, please') !!}
            {!!Form::textarea('reason', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::button('Send', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @include('layouts.validation_errors')

@endsection