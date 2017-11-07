<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\MenuService;
use App\Http\Requests\Admin\MenuRequest;

class MenuController extends BaseController
{
    protected $service;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = $this->service->getMenuList();
        return view(getThemeView('menu.list'))->with(compact('menus'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result = $this->service->create();
        return view(getThemeView('menu.create'))->with($result);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $result = $this->service->store($request->all());
        return response()->json($result);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->service->show($id);
        return view(getThemeView('menu.show'))->with($result);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = $this->service->edit($id);
        return view(getThemeView('menu.edit'))->with($result);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {
        $result = $this->service->update($request->all(), $id);
        return response()->json($result);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->route('menu.index');
    }
    /**
     * 清除菜单缓存
     * @author 晚黎
     * @date   2017-11-07
     * @return [type]     [description]
     */
    public function cacheClear()
    {
        $this->service->cacheClear();
        return redirect()->route('menu.index');
    }
}
