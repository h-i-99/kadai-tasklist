<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // タスク一覧を作成
        $tasks = Task::all();
        
        // タスク一覧ビューで表示
        return view('tasks.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        
        // タスク作成ページを表示
        return view('tasks.create', ['task' => $task]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // タスクを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
        // 一覧ページへリダイレクト
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // タスクを取得
        $task = Task::findOrFail($id);
        
        // 詳細ページを表示
        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // タスク取得
        $task = Task::findOrFail($id);
        
        // タスク編集ページを表示
        return view('tasks.edit', ['task' => $task]);
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
        // タスク取得
        $task = Task::findOrFail($id);
        
        // タスク更新
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
        // 一覧ページへリダイレクト
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // タスク取得
        $task = Task::findOrFail($id);
        
        // タスク削除
        $task->delete();
        
        // 一覧ページへリダイレクト
        return redirect('/');
    }
}
