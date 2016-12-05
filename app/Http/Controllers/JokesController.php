<?php

namespace App\Http\Controllers;

use App\Joke;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Node\Builder;

class JokesController extends Controller
{
    public function __construct()
    {
//        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        header('Access-Control-Allow-Origin: *');
        $limit = ($request->input('limit'))?$request->input('limit'):5;
        $jokes = DB::table('jokes')
            ->join('users','users.id','=','jokes.user_id')
            ->select(['body','name','email','jokes.id as joke_id','users.id as user_id'])
            ->paginate($limit);

        return response()->json(['data' => $jokes],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( !$request->get('body') || !$request->get('user_id') ) {
            return response()->json(['error' => 'Please provide more data'],404);
        }
        $joke = Joke::create($request->all());

        return response()->json(['message' => 'Create success','data' => $joke],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $joke = DB::table('jokes')
            ->where('jokes.id',$id)
            ->join('users','users.id','=','jokes.user_id')
            ->select(['body','name','email','jokes.id as jokes_id','users.id as users_id'])
            ->first();
        if(!$joke){
            return response()->json(['error' => 'Jokes does not exists'],404);
        }
        $prev = Joke::where('id','<',$joke->jokes_id)->max('id');
        $next = Joke::where('id','>',$joke->jokes_id)->min('id');
        return response()->json(['data' => $joke,'next' => $next,'prev' => $prev],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $joke = DB::table('jokes')
        ->where('jokes.id',$id)->first();
        return view('Jokes.edit',compact('id','joke'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $result = DB::table('jokes')
                ->where('jokes.id',$id)
                ->update([
                'body' => $request->get('body'),
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json(['message' => 'error'],200);
        }

        DB::commit();
        return response()->json(['message' => 'success','data' => $result],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
