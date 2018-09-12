<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\GroupRequest;

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
        return view('group.show', compact('group'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group.create');
    }

    /**
     * @param GroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->all());
        return redirect()->route('group.show',[$group])->with('success', '小组创建成功！');
    }

    /**
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Group $group)
    {
        $this->authorize('update', $group);
        return view('group.edit'. compact('group'));
    }

    /**
     * @param GroupRequest $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(GroupRequest $request, Group $group)
    {
        $this->authorize('update', $group);
        $group->update($request->all());
        return redirect()->intended()->with('success', '更新小组成功！');
    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Group $group)
    {
        $this->authorize('destroy', $group);
        $group->delete();
        return redirect()->intended('/')->with('success', '小组删除成功');
    }
}
