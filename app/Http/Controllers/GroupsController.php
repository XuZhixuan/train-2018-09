<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Http\Requests\GroupRequest;
use Illuminate\Support\Facades\Auth;

class GroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['index']
        ]);
    }

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
        $another = User::find($request->member_2);
        if ($another->group) {
            return redirect()->intended('/')->with('message','选择的人已加入一个小组');
        }
        $group = Group::create([
            'name' => $request->name,
            'domain_name' => 'http://' . $request->name . '.eeyes.xyz',
            'db_username' => 'db_' . $request->name,
            'db_password' => encrypt(generate_password(16)),
            'ftp_username' => 'ftp_' . $request->name,
            'ftp_password' => encrypt(generate_password(16)),
        ]);
        Auth::user()->update(['group_id' => $group->id]);
        $another->update(['group_id' => $group->id]);
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
