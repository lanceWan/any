@extends('layouts.'.getTheme())
@section('css')
<link href="{{asset(getThemeAssets('dataTables/datatables.min.css', true))}}" rel="stylesheet">
@endsection
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>{!!trans('role.title')!!}</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('admin')}}">{!!trans('home.title')!!}</a>
        </li>
        <li class="active">
            <strong>{!!trans('role.title')!!}</strong>
        </li>
    </ol>
  </div>
  <div class="col-lg-2">
    <div class="title-action">
      @if(hasPermission('rolecontroller.create'))
      <a href="{{route('role.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> {!!trans('common.create').trans('role.slug')!!}</a>
      @endif
    </div>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox">
        <div class="ibox-title">
          <h5>{!!trans('role.title')!!}</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
            <a class="close-link">
                <i class="fa fa-times"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          @include('flash::message')
          {!! $html->table(['class' => 'table table-striped table-bordered table-hover']) !!}
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content animated bounceInRight">
          
    </div>
  </div>
</div>
@endsection
@section('js')
  <script src="{{asset(getThemeAssets('dataTables/datatables.min.js', true))}}"></script>
  <script src="{{asset(getThemeAssets('layer/layer.js', true))}}"></script>
  <script type="text/javascript">
    $(document).on('click','.destroy_item',function() {
      var _item = $(this);
      var title = "{{trans('common.deleteTitle').trans('role.slug')}}？";
      layer.confirm(title, {
        btn: ['{{trans('common.yes')}}', '{{trans('common.no')}}'],
        icon: 5
      },function(index){
        _item.children('form').submit();
        layer.close(index);
      });
    });
  </script>
  {!! $html->scripts() !!}
@endsection