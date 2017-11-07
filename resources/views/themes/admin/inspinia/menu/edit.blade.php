@inject('menuPresenter','App\Repositories\Presenters\Admin\MenuPresenter')
<div class="ibox float-e-margins animated bounceIn formBox" id="createBox">
  <div class="ibox-title">
    <h5>{{trans('common.edit').$menu->name.trans('menu.desc')}}</h5>
    <div class="ibox-tools">
      <a class="close-link">
          <i class="fa fa-times"></i>
      </a>
    </div>
  </div>
  <div class="ibox-content">
    <form method="post" action="{{route('menu.update', [encodeId($menu->id, 'menu')])}}" class="form-horizontal" id="editForm">
      {!!csrf_field()!!}
      {{method_field('PUT')}}
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.name')}}</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" value="{{$menu->name}}" name="name">
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.pid')}}</label>
        <div class="col-sm-10">
          <select data-live-search="true" class="selectpicker form-control" name="pid">
            {!!$menuPresenter->topMenuList($menus, $menu->pid)!!}
          </select>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.icon')}}</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" placeholder="{{trans('menu.icon')}}" value="{{$menu->icon}}" name="icon">
          <span class="help-block m-b-none">{!!trans('menu.moreIcon')!!}</span>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.slug')}}</label>
        <div class="col-sm-10">
          <select data-live-search="true" class="selectpicker form-control" name="slug">
            {!!$menuPresenter->permissionList($permissions, $menu->slug)!!}
          </select>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.url')}}</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" placeholder="{{trans('menu.url')}}" value="{{$menu->url}}" name="url">
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.active')}}</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" placeholder="{{trans('menu.active')}}" value="{{$menu->active}}" name="active">
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.menu_description')}}</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" placeholder="{{trans('menu.menu_description')}}" value="{{$menu->description}}" name="description">
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
        <label class="col-sm-2 control-label">{{trans('menu.sort')}}</label>
        <div class="col-sm-10">
          <input type="text" id="sort"  name='sort' class="form-control"/>
        </div>
      </div>
      <div class="hr-line-dashed"></div>
      <div class="form-group">
          <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white close-link">{!!trans('common.close')!!}</a>
            <button class="btn btn-primary editButton ladda-button"  data-style="zoom-in">{!!trans('common.edit')!!}</button>
          </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
  $('.selectpicker').selectpicker();
  $('#sort').ionRangeSlider({
      type: "single",
      min: 0,
      max: 100,
      from: "{{$menu->sort}}"
  });
</script>