<?php

namespace App\Http\Controllers;
use App\Task;
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
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
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
}
