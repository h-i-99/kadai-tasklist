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
        $tasks = [];
        if (\Auth::check()) {
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザーのタスクを取得
            $tasks = $user->tasks()->get();
        }
        
        // タスク一覧ビューで表示
        return view('welcome', ['tasks' => $tasks]);
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
        // バリデーション
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);
        
        // タスクを作成
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);
        
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
        
        if (\Auth::user()->id == $task->user_id) {
            // 認証ユーザとタスク所有ユーザが一致する場合は、詳細ページを表示
            return view('tasks.show', ['task' => $task]);
        }

        // ユーザが不一致の場合は一覧ページへリダイレクト
        return redirect('/');
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
        
        if (\Auth::user()->id == $task->user_id) {
            // 認証ユーザとタスク所有ユーザが一致する場合は、編集ページを表示
            return view('tasks.edit', ['task' => $task]);
        }

        // ユーザが不一致の場合は一覧ページへリダイレクト
        return redirect('/');
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
        // バリデーション
        $request->validate([
            'content' => 'required',
            'status' => 'required|max:10',
        ]);

        // タスク取得
        $task = Task::findOrFail($id);
        
        if (\Auth::user()->id == $task->user_id) {
            // 認証ユーザとタスク所有ユーザが一致する場合は更新
            $task->content = $request->content;
            $task->status = $request->status;
            $task->save();
        } else {
            // ユーザ不一致（不正リクエスト）の場合は403エラーを表示したい
        }
        
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

        if (\Auth::user()->id == $task->user_id) {
            // タスク削除
            $task->delete();
        } else {
            // ユーザ不一致（不正リクエスト）の場合は403エラーを表示したい
        }

        // 一覧ページへリダイレクト
        return redirect('/');
    }
}
