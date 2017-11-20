<?php
namespace App\Http\ViewComposers;
use Illuminate\View\View;
use App\Services\Admin\MenuService;
class MenuComposer
{
    
    protected $service;

    
    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    
    public function compose(View $view)
    {
        $view->with('sidebarMenu', $this->service->getMenuList());
    }
}