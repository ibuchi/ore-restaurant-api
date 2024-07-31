<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Menu::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::api([
            'message' => 'All menus!',
            'data' => Menu::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRequest $request)
    {
        return Response::api([
            'message' => 'Menu added!',
            'data' => Menu::create($request->validated())
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return Response::api([
            'message' => 'Menu!',
            'data' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return Response::api([
            'message' => 'Menu updated!',
            'data' => $menu
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        Response::api('Menu item deleted!');
    }

    public function discountedMenus()
    {
        return Response::api([
            'message' => 'Discounted Menus!',
            'data' => Menu::whereIsDiscounted(true)->get(),
        ]);
    }

    public function drinkMenus()
    {
        return Response::api([
            'message' => 'Drinks on the menu!',
            'data' => Menu::whereCategory('drink')->get(),
        ]);
    }
}
