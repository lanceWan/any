@extends('layouts.'.getTheme())
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset(getThemeAssets('nestable/nestable.css', true))}}">
<link rel="stylesheet" type="text/css" href="{{asset(getThemeAssets('bootstrap-select/bootstrap-select.min.css', true))}}">
<link rel="stylesheet" type="text/css" href="{{asset(getThemeAssets('ladda/ladda-themeless.min.css', true))}}">
@endsection
@section('content')
@inject('menuPreseter','App\Presenters\Admin\MenuPresenter')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>{!!trans('menu.title')!!}</h2>
    <ol class="breadcrumb">
      <li>
            <a href="{{url('admin')}}">{!!trans('home.title')!!}</a>
        </li>
        <li class="active">
            <strong>{!!trans('menu.title')!!}</strong>
        </li>
    </ol>
  </div>
  <div class="col-lg-2">
    <div class="title-action">
      <a href="#" class="btn btn-info"><i class="fa fa-cancel"></i> 
        {{trans('menu.cache_clear')}}
      </a>
    </div>
  </div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
  <div class="row">
    @include('flash::message')
    <div class="col-lg-6">
      <div class="ibox animated fadeInRightBig">
        <div class="ibox-title">
            <h5>{!!trans('menu.desc')!!}</h5>
        </div>
        <div class="ibox-content">
          <div class="dd" id="nestable">
              <ol class="dd-list">
                {!!$menuPreseter->menuNestable($menus)!!}
              </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 menuBox">
        {!!$menuPreseter->canCreateMenu()!!}
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{asset(getThemeAssets('nestable/jquery.nestable.js', true))}}"></script>
<script src="{{asset(getThemeAssets('bootstrap-select/bootstrap-select.min.js', true))}}"></script>
<script src="{{asset(getThemeAssets('ladda/spin.min.js', true))}}"></script>
<script src="{{asset(getThemeAssets('ladda/ladda.min.js', true))}}"></script>
<script src="{{asset(getThemeAssets('ladda/ladda.jquery.min.js', true))}}"></script>
<script src="{{asset(getThemeAssets('layer/layer.js', true))}}"></script>
<script src="{{asset(getThemeAssets('js/menu.js'))}}"></script>
<script type="text/javascript">
  $('#nestable').on('click','.destroy_item',function() {
    var _item = $(this);
    var title = "{{trans('admin/alert.deleteTitle')}}";
    layer.confirm(title, {
      btn: ['{{trans('admin/action.actionButton.destroy')}}', '{{trans('admin/action.actionButton.no')}}'],
      icon: 5
    },function(index){
      _item.children('form').submit();
      layer.close(index);
    });
  });
</script>
@endsection