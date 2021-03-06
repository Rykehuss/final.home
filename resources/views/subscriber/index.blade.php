@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">SUBSCRIBERS</div>
                    <div class="panel-body">

                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        {{ link_to_route('subscriber.create', 'Create', $bunch_id, ['class' => 'btn btn-info btn-xs']) }}
                        <table class="table table-bordered table-responsive table-striped table-hover">
                            <tr>
                                <th width="10%">id</th>
                                <th width="20%">Name</th>
                                <th width="20%">Surname</th>
                                <th width="20%">E-Mail</th>
                                <th width="10">At bunches</th>
                                <th width="20%">action</th>
                            </tr>
                            <tr>
                                <td colspan="3" class="light-green-background no-padding" title="Create new subscriber">
                                    <div class="row centered-child">
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($subscribers as $model)
                                <tr class="as-link clickable_row" link="{!! route('subscriber.show', [$bunch_id, $model]) !!}">
                                    <td>{{$model->id}}</td>
                                    <td>{{$model->name}}</td>
                                    <td>{{$model->surname}}</td>
                                    <td>{{$model->email}}</td>
                                    <td>{{$model->bunches->count()}}</td>
                                    <td>
                                        {{Form::open(['class' => 'confirm-delete', 'route' => ['subscriber.destroy', $bunch_id, $model],
                                        'method' => 'DELETE'])}}
                                        {{ link_to_route('subscriber.show', 'Info', [$bunch_id, $model], ['class' => 'btn btn-info btn-xs']) }}
                                        {{ link_to_route('subscriber.edit', 'Edit', [$bunch_id, $model], ['class' => 'btn btn-success btn-xs']) }}
                                        {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                                        {{Form::close()}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection