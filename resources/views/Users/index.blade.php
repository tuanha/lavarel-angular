@extends('layouts.app')

@section('content')
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">{!! trans('default.UserManager') !!} / {!! trans('default.main') !!} - <a href="{!! route('users.add') !!}">{!! trans('default.create') !!}</a></div>
        <div class="panel-body">
            @if (session('message'))
                <p>
                    {{ session('message') }}
                </p>
            @endif
            <div class="row">
                <div class="col-md-12">
                <table class="table-responsive table-bordered table-striped table-hover" width="100%">
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Password</td>
                        <td>Delete</td>
                        <td>Edit</td>
                    </tr>

                    @foreach($data as $row)
                        <tr>
                            <td>{!! $row->id !!}</td>
                            <td>{!! $row->name !!}</td>
                            <td>{!! $row->email !!}</td>
                            <td>{!! $row->password !!}</td>
                            <td>
                                <form action="{!! route('users.destroy',$row->id) !!}" method="post">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                            <td><a href="{!! route('users.edit',$row->id) !!}">Edit</a></td>
                        </tr>
                    @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection