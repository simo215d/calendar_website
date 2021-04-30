<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tasks = Task::all();
        return view('home')->with(['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        //since I in my html need to calculate how big the div containing the task and its 
        //position i thought percentage was easier to work with, so thats how im storing the data
        //the time gets in the request like 12:30 but hours arent the same as minutes so they need to be calculated differently
        $starttime_h = ((floatval(substr($request->starttime, 0,2)))/24)*100;
        $starttime_m = (((floatval(substr($request->starttime, 3,4)))/60)/24)*100;
        $starttime = $starttime_h+$starttime_m;
        $endtime_h = ((floatval(substr($request->endtime, 0,2)))/24)*100;
        $endtime_m = (((floatval(substr($request->endtime, 3,4)))/60)/24)*100;
        $endtime = $endtime_h+$endtime_m;
        $user_id = Auth::user()->id;
        //finally create the task based on input from the request, and users login id
        Task::create(['starttime' => $starttime] + ['endtime' => $endtime] + ['name' => $request->name] + ['day' => $request->day] + ['owner_fk' => $user_id]);
        //to refresh the page since new data is in database
        return redirect()->route('home');
    }

    public function destroy(Request $request)
    {
        $task = Task::find($request->id);
        $task->delete();
        return redirect()->route('home');
    }
}