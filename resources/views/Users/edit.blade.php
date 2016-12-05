<form action="{!! route('users.update',$data->id) !!}" method="post">
    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="name" placeholder="name" value="{!! $data->name !!}"><br>
    <input type="text" name="email" placeholder="email" value="{!! $data->email !!}"><br>
    <input type="password" name="password" placeholder="password" value="{!! $data->password !!}"><br>
    <input type="submit" value="Save">
</form>