@extends('layouts.panel')
@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2"
               href="{{route('bunch.editSubscribers', compact('bunch_id'))}}">
                <i class="fa fa-backward" aria-hidden="true"></i> Back
            </a>
            <div class="centered-child col-md-9 col-sm-7 col-xs-6">Subscriber: <b>{{$subscriber->email}}</b></div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <div class="pull-right">
                    {{Form::open(['class' => 'confirm-delete', 'route' => ['subscriber.destroy', $bunch_id, $subscriber], 'method' => 'DELETE'])}}
                    {{ link_to_route('subscriber.edit', 'Edit', [$bunch_id, $subscriber], ['class' => 'btn btn-primary btn-xs']) }} |
                    {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-responsive">
            <tr>
                <th width="25%">Attribute</th>
                <th width="75%">Value</th>
            </tr>
            @foreach ($subscriber->getAttributes() as $attribute => $value)
                <tr>
                    <td>{{$attribute}}</td>
                    <td>{{$value}}</td>
                </tr>
            @endforeach
        </table>

        <div><b>Added to Bunches:</b></div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
            </tr>
            @foreach ($subscriber->bunches as $bunch)
                <tr>
                    <td>{{$bunch->id}}</td>
                    <td>{{$bunch->name}}</td>
                    <td>{{$bunch->description}}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection