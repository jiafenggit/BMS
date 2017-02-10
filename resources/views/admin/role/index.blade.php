@extends('layouts.admin.admin-master')

@section('breadcumb')
<!-- breadcrumb -->
<ol class="breadcrumb">
    <li>后台</li>
    <li>权限</li>
    <li>角色列表</li>
</ol>
<!-- end breadcrumb -->
@stop

@section('content')
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<!-- Widget ID (each widget will need unique ID)-->
	<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
		<!-- widget options:
		usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

		data-widget-colorbutton="false"
		data-widget-editbutton="false"
		data-widget-togglebutton="false"
		data-widget-deletebutton="false"
		data-widget-fullscreenbutton="false"
		data-widget-custombutton="false"
		data-widget-collapsed="true"
		data-widget-sortable="false"

		-->
		<header>
			<span class="widget-icon"> <i class="fa fa-table"></i> </span>
			<h2>角色列表</h2>

		</header>

		<!-- widget div-->
		<div>

			<!-- widget edit box -->
			<div class="jarviswidget-editbox">
				<!-- This area used as dropdown edit box -->

			</div>
			<!-- end widget edit box -->

			<!-- widget content -->
			<div class="widget-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>角色名称</th>
								<th>创建时间</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody>
							@if(count($roles)>0)
							@foreach($roles as $v)
							<tr>
								<td>{{$v->id}}</td>
								<td>{{$v->display_name}}</td>
								<td>{{$v->created_at}}</td>
								<td>
									<a class="btn btn-xs btn-primary" href="{{route('role.edit',['id'=>$v->id])}}"><span class="fa fa-pencil"></span></a>
									<a class="btn btn-xs btn-danger delete" href="javascript:;" data-href="{{route('role.destroy',['id'=>$v->id])}}"><span class="fa fa-times"></span></a>
								</td>
							</tr>
							@endforeach
							@else
							<tr >
								<td colspan="4">暂无数据</td>
							</tr>
							@endif
						</tbody>
					</table>

					<div class="col-sm-6 col-xs-12 hidden-xs"></div>
					<div class="col-sm-6 col-xs-12">
						<div class="dataTables_paginate paging_simple_numbers" id="dt_basic_paginate">
						{!!$roles->links()!!}
						</div>
					</div>

				</div>

				<a class="btn btn-xs btn-primary" href="{{route('role.create')}}"><span class="fa fa-plus"></span>添加角色</a>
			</div>
			<!-- end widget content -->

		</div>
		<!-- end widget div -->

	</div>
	<!-- end widget -->
</article>
@stop

