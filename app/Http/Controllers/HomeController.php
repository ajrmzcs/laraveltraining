<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        $x = [
            [
                'id' => 1,
                'title' => 'meeting1',
                'start' => '2018-04-20'
            ],
            [
                'id' => 2,
                'title' => 'meeting2',
                'start' => '2018-04-20'
            ]
        ];

        return response()->json($x);
    }
}
