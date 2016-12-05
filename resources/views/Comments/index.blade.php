@extends('layouts/app')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Manager Comments / Main - <a href="{!! route('comments.create') !!}">Create</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-hover table-striped table-responsive">
                    <tr>
                        <th>ID</th>
                        <th>Comment</th>
                        <th>User_id</th>
                        <th>Action</th>
                    </tr>
                    @if(count($data) == 0)
                        <tr>
                            <td colspan="3" class="text-center">No data</td>
                        </tr>
                    @endif
                    @foreach($data as $row)
                        <tr>
                            <td>{!! $row->id !!}</td>
                            <td>{!! $row->comment !!}</td>
                            <td>{!! $row->user_id !!}</td>
                            <td width="18%">
                                <div class="btn-group btn-group-justified" role="group">
                                    <div class="btn-group btn-group-xs" role="group">
                                        <button type="button" class="btn btn-success" title="Edit" data-toggle="tooltip" data-placement="top">Edit</button>
                                    </div>
                                    <div class="btn-group btn-group-xs" role="group">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal" data-placement="top">Delete</button>
                                    </div>
                                    <div class="btn-group btn-group-xs" role="group">
                                        <button type="button" class="btn btn-default" title="View" data-toggle="tooltip" data-placement="top">View</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="panel-footer">
                12
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection