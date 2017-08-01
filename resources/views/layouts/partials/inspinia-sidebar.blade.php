@inject('menuPresenter','App\Presenters\Admin\MenuPresenter')
<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
      <li class="nav-header">
          <div class="dropdown profile-element"> <span>
            <img alt="image" class="img-circle" src="{{asset(getThemeAssets('img/profile_small.jpg'))}}" />
             </span>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
              <span class="clear"></span>
              <span class="block m-t-xs"><strong class="font-bold">晚黎</strong></span>
            </a>
          </div>
          <div class="logo-element">
            Any
          </div>
      </li>
      
      {!!$menuPresenter->sidebarMenuList($sidebarMenu)!!}
      
    </ul>
  </div>
</nav>