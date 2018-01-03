@extends('layouts.panel')
@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <div class="centered-child col-md-11 col-sm-10 col-xs-10"><b>New Bunch</b></div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['route' => 'bunch.store']) !!}
        @include('bunch._form')
        <div class="form-group">
            {!! Form::button('Create', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @include('layouts.validation_errors')

@endsection