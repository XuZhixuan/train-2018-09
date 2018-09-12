<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $departments = Department::all();
        return view('users.edit', compact('user','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update([
            'email' => $request->email,
            'department_id' => $request->department_id,
        ]);
        if ($request->has('avatar') && $request->file('avatar')->isValid()) {
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
            $user->save();
        }
        return redirect()->intended('/')->with('success', '用户信息更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     *     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        return redirect()->intended('/')->with('success', '删除成功！');
    }
}
