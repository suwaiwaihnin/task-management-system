<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use DB;


class TaskController extends Controller
{

    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $complete_task = Task::where('status','complete')->latest()->orderBy('complete_date','DESC')->paginate(5);
        $incomplete_task = Task::where('status','incomplete')
                          ->orderBy('schedule_date','asc','complete','asc')
                          ->paginate(5);
        return Inertia::render('Task/Index',['complete_task'=>$complete_task,'incomplete_task'=>$incomplete_task]);
    }

    public function create()
    {
        return Inertia::render('Task/Create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'schedule_date' => 'required|date_format:Y-m-d|after:yesterday',
            'complete_date' => 'required|date_format:Y-m-d|after_or_equal:schedule_date',
            'priority' => 'required'
        ]);
        Task::create([
            'title' => $request->title,
            'schedule_date' => $request->schedule_date,
            'complete_date' => $request->complete_date,
            'priority' => $request->priority,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/task')->with('success','Task Created Successfully');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $task = Task::find($id);
        return Inertia::render('Task/Edit',['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        $today = Carbon::now()->format('Y-m-d');
        // Check schedule date exist
        if($request->schedule_date){
            $request->validate([
                'title' => 'required',
                'complete_date' => 'required|date_format:Y-m-d|after_or_equal:schedule_date',
                'priority' => 'required'
            ]);
        }else{
            $request->validate([
                'title' => 'required',
                'schedule_date' => 'required|date_format:Y-m-d|after:yesterday',
                'complete_date' => 'required|date_format:Y-m-d|after_or_equal:schedule_date',
                'priority' => 'required'
            ]);
        }
        $task = Task::where('id',$id);
        $task->update([
            'title' => $request->title,
            'schedule_date' => $request->schedule_date,
            'complete_date' => $request->complete_date,
            'priority' => $request->priority,
            'user_id' => Auth::user()->id
        ]);
        return redirect('/task')->with('success','Task Updated Successfully');
    }

    public function destroy(Request $request)
    {
       foreach($request->data as $id) {
           Task::findOrFail($id)->delete();
       }
       return redirect('/task')->with('success','Delete Success');
    }

    public function makeComplete(Request $request){
        foreach($request->data as $id){
            Task::where('id',$id)->update([
                'status'=> 'complete'
            ]);
        }
        return redirect()->back()->with('info','Changed Status');
    }

    //Search by Title
    public function searchTask($search){
       $complete_task = Task::where(DB::raw('LOWER(title)'), 'like', '%' .  strtolower($search) . '%')->where('status','complete')->latest()->paginate(5);
       $incomplete_task = Task::where(DB::raw('LOWER(title)'), 'like', '%' .  strtolower($search) . '%')->where('status','incomplete')->latest()->paginate(5);
       return Inertia::render('Task/Index',['complete_task'=>$complete_task,'incomplete_task'=>$incomplete_task]);
    }
}
