<form action="{!! route('jokes.update',$id) !!}" method="POST">
    {!! csrf_field() !!}
    <input type="hidden" name="_method" value="PUT">
    <input type="text" name="body" value="{!! $joke->body !!}">
    <button type="submit">Save</button>
</form>