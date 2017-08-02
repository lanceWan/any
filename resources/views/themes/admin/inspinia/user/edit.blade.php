@extends('layouts.'.getTheme())
@section('css')
<link href="{{asset(getThemeAssets('iCheck/custom.css', true))}}" rel="stylesheet">
@endsection
@section('content')
@inject('userPresenter','App\Presenters\Admin\UserPresenter')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>{!!trans('admin/user.title')!!}</h2>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('admin')}}">{!!trans('home.title')!!}</a>
        </li>
        <li>
            <a href="{{route('user.index')}}">{!!trans('user.title')!!}</a>
        </li>
        <li class="active">
            <strong>{!!trans('common.create').trans('user.slug')!!}</strong>
        </li>
    </ol>
  </div>
  <div class="col-lg-2">
    <div class="title-action">
      <a class="btn btn-white" href="{{route('user.index')}}"><i class="fa fa-reply"></i>  {!!trans('common.cancel')!!}</a>
    </div>
  </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>{!!trans('common.create').trans('user.slug')!!}</h5>
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
          <form method="post" action="{{route('user.update', [encodeId($user->id, 'user')])}}" class="form-horizontal">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">{{trans('user.name')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{old('name', $user->name)}}" placeholder="{{trans('user.name')}}"> 
                @if ($errors->has('name'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('name') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">{{trans('user.username')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="username" value="{{old('username', $user->username)}}" placeholder="{{trans('user.username')}}"> 
                @if ($errors->has('username'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('username') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">{{trans('user.password')}}</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password" value="{{old('password')}}" placeholder="{{trans('user.password')}}"> 
                <span class="help-block text-warning m-b-none">{{trans('user.password_info')}}</span>
                @if ($errors->has('password'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('password') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label class="col-sm-2 control-label">{{trans('user.email')}}</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="email" value="{{old('email', $user->email)}}" placeholder="{{trans('user.email')}}">
                @if ($errors->has('email'))
                <span class="help-block m-b-none text-danger">{{ $errors->first('email') }}</span>
                @endif
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label">{{trans('user.role')}}</label>
              <div class="col-sm-10">
                {!!$userPresenter->roleList($roles, array_column($user->roles->toArray(),'id'))!!}
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <label class="col-sm-2 control-label">{{trans('user.permission')}}</label>
              <div class="col-sm-10">
                <div class="ibox float-e-margins">
                  <div class="alert alert-warning">
                    {!!trans('user.other_permission')!!}
                  </div>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                          <th class="col-md-1 text-center">{{trans('role.module')}}</th>
                          <th class="col-md-10 text-center">{{trans('role.permission')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                      {!! $userPresenter->permissionList($permissions, array_column($user->userPermissions->toArray(),'id')) !!}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-2">
                  <a class="btn btn-white" href="{{route('user.index')}}">{!!trans('common.cancel')!!}</a>
                  @if(hasPermission('usercontroller.update'))
                  <button class="btn btn-primary" type="submit">{!!trans('common.edit')!!}</button>
                  @endif
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@include(getThemeView('user.modal'))
@endsection
@section('js')
<script type="text/javascript" src="{{asset(getThemeAssets('iCheck/icheck.min.js', true))}}"></script>
<script type="text/javascript" src="{{asset(getThemeAssets('js/check.js'))}}"></script>
@endsection