<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

use App\Model\Todo;

class TodoController extends Controller {

    public function __construct() {
        $this->middleware('jwt.auth', ['except' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = JWTAuth::parseToken()->authenticate();
        $todos = Todo::where('owner_id', $user->id) ->get();
 
        return $todos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        $newTodo = $request->all();
        $newTodo['owner_id']=$user->id;
        return Todo::create($newTodo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = Todo::where('owner_id', $user->id)->where('id',$id)->first();
 
        if($todo){
            $todo->is_done=$request->input('is_done');
            $todo->save();
            return $todo;
        }else{
            return response('Unauthoraized',403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $user = JWTAuth::parseToken()->authenticate();
        $todo = Todo::where('owner_id', $user->id)->where('id',$id)->first();
 
        if($todo){
             Todo::destroy($todo->id);
            return  response('Success',200);;
        }else{
            return response('Unauthoraized',403);
        }
    }

}
