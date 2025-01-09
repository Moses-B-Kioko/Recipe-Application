<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\PusherBroadcast;

class PusherController extends Controller
{
    public function index() 
    {
        return view('message.index');
    }

    public function broadcast(Request $request) 
    {
       // $request->validate([
         //   'message' => 'required|string|max:255',
        //]);

        broadcast(new PusherBroadcast($request->get('message')))->toOthers();

        return view('message.broadcast',['message' => $request->get('message')]);
    }

    public function receive(Request $request) 
    {
        //$request->validate([
           // 'message' => 'required|string|max:255',
        //]);

        return view('message.receive', ['message' => $request->get('message')]);
    }
}
