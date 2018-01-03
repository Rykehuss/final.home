@extends('layouts.panel')
@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2" href="{{route('bunch.index')}}">
                <i class="fa fa-backward" aria-hidden="true"></i> Back
            </a>
            <div class="centered-child col-md-9 col-sm-7 col-xs-6">Bunch: <b>{{$bunch->name}}</b></div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <div class="pull-right">
                    {{Form::open(['class' => 'confirm-delete', 'route' => ['bunch.destroy', $bunch], 'method' => 'DELETE'])}}
                    {{ link_to_route('bunch.edit', 'Edit', [$bunch], ['class' => 'btn btn-primary btn-xs']) }} |
                    {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div><b>Attributes:</b></div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th width="25%">Attribute</th>
                <th width="75%">Value</th>
            </tr>
            @foreach ($bunch->getAttributes() as $attribute => $value)
                <tr>
                    <td>{{$attribute}}</td>
                    <td>{{$value}}</td>
                </tr>
            @endforeach
        </table>

        <div><b>Subscribers:</b></div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Surname</th>
                <th>E-mail</th>
            </tr>
            @foreach ($bunch->subscribers as $subscriber)
                <tr>
                    <td>{{$subscriber->id}}</td>
                    <td>{{$subscriber->name}}</td>
                    <td>{{$subscriber->surname}}</td>
                    <td>{{$subscriber->email}}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection