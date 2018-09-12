<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Http\Requests\GroupRequest;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    /**
     * Display a listing of the groups.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::paginate(10);
        return view('groups.index', compact('groups'));
    }

    /**
     * Display the specified group.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->group) {
            return redirect()->intended('/')->with('message','您已加入一个小组');
        }
        $users = User::all();
        return view('groups.create', compact('users'));
    }

    /**
     * @param GroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        if (Auth::user()->group) {
            return redirect()->intended('/')->with('message','您已加入一个小组');
        }
        $group = Group::create([
            'name' => $request->name
        ]);
        Auth::user()->update(['group_id' => $group->id]);
        User::find($request->member_2)->update(['group_id' => $group->id]);
        return redirect()->route('users.show',[Auth::user()])->with('success', '小组创建成功！');
    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
        $group->delete();
        return redirect()->intended('/')->with('success', '小组删除成功');
    }
}
