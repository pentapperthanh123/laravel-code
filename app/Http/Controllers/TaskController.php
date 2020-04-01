<?php

namespace App\Http\Controllers;
use App\Task;
use DB;
use App\Http\Requests;
use App\Repositories\TaskRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{   
    // yêu cầu người dùng đã xác thực
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }
    public function index(Request $request)
    {
        $tasks = DB::table('tasks')->paginate(10);
        return view('tasks.index', ['tasks' => $tasks]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
    public function search(Request $request)
    {
        $search = $request->get('search');
        $tasks = DB::table('tasks')->where('name','like','%'.$search.'%')->paginate(10);
        return view('tasks.index',['tasks' => $tasks]);
    }
}
