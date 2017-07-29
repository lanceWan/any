@extends('layouts.'.getTheme())
@section('css')
<link href="{{asset(getThemeAssets('iCheck/custom.css', true))}}" rel="stylesheet">
@endsection
@section('content')
@inject('rolePresenter','App\Presenters\Admin\RolePresenter')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>{!!trans('role.title')!!}</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('admin')}}">{!!trans('home.title')!!}</a>
        </li>
        <li>
            <a href="{{route('role.index')}}">{!!trans('role.title')!!}</a>
        </li>
        <li class="active">
            <strong>{!!trans('common.create').trans('role.slug')!!}</strong>
        </li>
    </ol>
  </div>
  <div class="col-lg-2">
    <div class="title-action">
      <a class="btn btn-white" href="{{route('role.index')}}"><i class="fa fa-reply"></i>  {!!trans('common.cancel')!!}</a>
    </div>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>{!!trans('common.create').trans('role.slug')!!}</h5>
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
          <form method="post" action="{{route('role.store')}}" class="form-horizontal">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">{{trans('role.name')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="{{trans('role.name')}}"> 
                @if ($errors->has('name'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">{{trans('role.slug')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="slug" value="{{old('slug')}}" placeholder="{{trans('role.slug')}}"> 
                @if ($errors->has('slug'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('slug') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label">{{trans('role.description')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="description" value="{{old('description')}}" placeholder="{{trans('role.description')}}">
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label">{{trans('role.permission')}}</label>
              <div class="col-sm-10">
                <div class="ibox float-e-margins">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                          <th class="col-md-1 text-center">{{trans('role.module')}}</th>
                          <th class="col-md-10 text-center">{{trans('role.permission')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      {!! $rolePresenter->permissionList($permissions) !!}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-2">
                  <a class="btn btn-white" href="{{route('role.index')}}">{!!trans('common.cancel')!!}</a>
                  @haspermission('permissioncontroller.store')
                  <button class="btn btn-primary" type="submit">{!!trans('common.create')!!}</button>
                  @endhaspermission
              </div>
            </div>
          </form>
        </div>
    </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{asset(getThemeAssets('iCheck/icheck.min.js', true))}}"></script>
<script type="text/javascript" src="{{asset(getThemeAssets('js/role.js'))}}"></script>
@endsection