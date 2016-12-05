<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\In;
use League\Flysystem\Exception;
use App\Notifications\InvoicePaid;

class UsersController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        dd(Auth::attempt(['email' => 'nhien@demo.com','password' => '111111']));
//        notification via email
//        way 1:
//        $user = User::find(31);
//        $user->notify(new InvoicePaid());
//        way 2
//        Notification::send(User::all(),new InvoicePaid());
        

        $data = User::all();
        return view('Users.index',compact('data'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);

        $this->validate($request,[
            'name'  => 'required|min:6',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);

        DB::beginTransaction();
            try{
                $data['password'] = bcrypt($data['password']);
                $result = User::create($data);
            } catch (ValidationException $e){
                return redirect()->route('users.create')->withErrors($e->getErrors())->withInput();
            } catch (\Exception $e){
                DB::rollback();
                return redirect()->route('users.index')->with('message','Fail create');
            }
        DB::commit();

        return redirect()->route('users.index')->with('message','Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('users')->where('id', $id)->get()->first();
        dd($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('users')->where('id', $id)->lockForUpdate()->first();
        return view('Users.edit',compact('data'));
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

        try{
            $result = User::where('id',$id)->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return redirect()->route('users.index')->with('message','Fail update');
        }

        DB::commit();
        return redirect()->route('users.index')->with('message','Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function() use($id){
            DB::table('users')->delete(['id' => $id]);
        });
        return redirect()->route('users.index')->with('message','Success');
    }

    public function setCookie(){
        return response('{"a":"b"}', 200)->setEtag('111')
            ->header('Content-Type', 'nhien')->cookie('nhien','nguyen');
    }

    /**
     * @return string
     */
    public function getCookie(Request $request)
    {
        dd($request->cookie('nhien'));
    }
}
