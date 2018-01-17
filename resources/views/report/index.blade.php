@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">REPORTS</div>
                    <div class="panel-body">

                        @if(Session::has('status'))
                            <div class="alert alert-success">
                                {{ Session::get('status') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <table class="table table-bordered table-responsive table-striped table-hover">
                            <tr>
                                <th width="10%">id</th>
                                <th width="40%">Campaign</th>
                                <th width="40%">Date</th>
                                <th width="10%">action</th>
                            </tr>
                            @foreach ($reports as $model)
                                <tr link="{{"report/".$model->id}}" class="clickable_row as-link">
                                    <td>{{$model->id}}</td>
                                    <td>{{$model->campaign->name}}</td>
                                    <td>{{$model->created_at}}</td>
                                    <td>
                                        {{ link_to_route('report.show', 'Info', [$model], ['class' => 'btn btn-info btn-xs']) }}
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