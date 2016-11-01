<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use App\Classes\Unifiapi;

use App\login;

class login extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("login");
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
        app('App\Http\Controllers\Unifiapi')->init(session('mac'),session('ap'));
        $name = $_POST['name'];
        $name = $_POST['email'];
        $name = $_POST['phone'];
        $mac = session('mac');

        $user = $this->registerUser($name,$email,$phone,$mac);
        login::create($user);
        return redirect('http://epointnet.com');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    private function registerUser($name,$email,$phone,$mac){
        $user = new \App\login;
 
        $user->email = $email;
        $user->name = $name;
        $user->phone = $phone;
        $user->mac = $mac;
        $user->save();
 
        return $user;
    }
}
