@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">CAMPAIGNS</div>
                    <div class="panel-body">

                        @if(Session::has('status'))
                            <div class="alert alert-success">
                                {{ Session::get('status') }}
                            </div>
                        @endif

                        {{ link_to_route('campaign.create', 'Create', null, ['class' => 'btn btn-info btn-xs']) }}
                        <table class="table table-bordered table-responsive table-striped table-hover">
                            <tr>
                                <th width="5%">id</th>
                                <th width="15%">Name</th>
                                <th width="20%">Description</th>
                                <th width="15%">Template</th>
                                <th width="15%">Bunch</th>
                                <th width="25%">action</th>
                            </tr>
                            @foreach ($campaigns as $model)
                                <tr link="{{"campaign/".$model->id}}" class="clickable_row as-link">
                                    <td>{{$model->id}}</td>
                                    <td>{{$model->name}}</td>
                                    <td>{{$model->description}}</td>
                                    <td>{{$model->template->name}}</td>
                                    <td>{{$model->bunch->name}}</td>
                                    <td>
                                        {{Form::open(['class' => 'confirm-delete', 'route' => ['campaign.destroy', $model],
                                        'method' => 'DELETE'])}}
                                        {{ link_to_route('campaign.preview', 'Preview', [$model], ['class' => 'btn btn-warning btn-xs']) }}
                                        {{ link_to_route('campaign.show', 'Info', [$model], ['class' => 'btn btn-info btn-xs']) }}
                                        {{ link_to_route('campaign.edit', 'Edit', [$model], ['class' => 'btn btn-success btn-xs']) }}
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