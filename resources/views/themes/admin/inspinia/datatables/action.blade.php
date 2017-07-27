	<a href="{{ $route['edit'] }}" class="btn btn-xs btn-outline btn-warning tooltips" data-original-title="{{trans('common.edit')}}" data-placement="top">
		<i class="fa fa-edit"></i>
	</a>
	<a href="javascript:;" onclick="return false" class="btn btn-xs btn-outline btn-danger tooltips destroy_item" data-original-title="{{trans('common.delete')}}"  data-placement="top">
		<i class="fa fa-trash"></i>
		<form action="{{ $route['destroy'] }}" method="POST" style="display:none">
			{{ csrf_field() }}
			{{ method_field('delete') }}
		</form>
	</a>