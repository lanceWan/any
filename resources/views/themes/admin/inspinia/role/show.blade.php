@inject('rolePresenter','App\Repositories\Presenters\Admin\RolePresenter')
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <h4 class="modal-title">{{trans('common.show').$role->name.trans('role.slug')}}</h4>
</div>
<div class="modal-body">
  <form class="form-horizontal">
    <div class="hr-line-dashed no-margins"></div>
    <div class="form-group">
      <label class="col-sm-3 control-label">{{trans('role.name')}}</label>
      <div class="col-sm-8">
        <p class="form-control-static">{{$role->name}}</p>
      </div>
    </div>
    <div class="hr-line-dashed no-margins"></div>
    <div class="form-group">
      <label class="col-sm-3 control-label">{{trans('role.slug')}}</label>
      <div class="col-sm-8">
        <p class="form-control-static">{{$role->slug}}</p>
      </div>
    </div>
    <div class="hr-line-dashed no-margins"></div>
    <div class="form-group">
      <label class="col-sm-3 control-label">{{trans('role.description')}}</label>
      <div class="col-sm-8">
        <p class="form-control-static">{{$role->description}}</p>
      </div>
    </div>
    <div class="hr-line-dashed no-margins"></div>
    <div class="form-group">
      <label class="col-sm-3 control-label">{{trans('role.created_at')}}</label>
      <div class="col-sm-8">
        <p class="form-control-static">{{$role->created_at}}</p>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12">
        <div class="ibox float-e-margins">
          <div class="ibox-content">
            <table class="table table-bordered">
              <thead>
              <tr>
                <th class="col-md-2 text-center">{{trans('role.module')}}</th>
                <th class="col-md-10 text-center">{{trans('role.permission')}}</th>
              </tr>
              </thead>
              <tbody>
              {!!$rolePresenter->showRolePermissions($role->permissions)!!}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">{!!trans('common.close')!!}</button>
</div>