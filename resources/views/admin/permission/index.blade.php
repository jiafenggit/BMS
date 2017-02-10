@extends('layouts.admin.admin-master')

@section('title') 权限列表 @stop

@section('breadcumb')
<!-- breadcrumb -->
<ol class="breadcrumb">
    <li>后台</li>
    <li>权限</li>
    <li>权限列表</li>
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
			<h2>权限列表</h2>

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
				<a class="btn btn-xs btn-default" href="{{route('permission.create')}}"><span class="fa fa-plus"></span>添加权限</a>
				<br>
				<div class="row">
				
					<div class="col-sm-6 col-lg-6">
						<div class="dd" id="nestable3">
							<ol class="dd-list">
								@foreach($perms as $v)
								<li class="dd-item dd3-item" data-id="{{$v['id']}}">
									<div class="dd-handle dd3-handle">
										Drag
									</div>
									<div class="dd3-content">
										{{$v['display_name']}} 
										
										<div class="pull-right">
											<div class="checkbox no-margin">
												<label>
												<a class="btn btn-xs btn-primary" href="{{route('permission.edit',['id'=>$v['id']])}}"><span class="fa fa-pencil"></span></a>
												<a class="btn btn-xs btn-danger delete" href="javascript:;" data-href="{{route('permission.destroy',['id'=>$v['id']])}}"><span class="fa fa-times"></span></a>
												</label>
											</div>
										</div>
								
									</div>
									@if(count($v['child'])>0)
									<ol class="dd-list">
										@foreach($v['child'] as $v2)
										<li class="dd-item dd3-item" data-id="{{$v['id']}}">
											<div class="dd-handle dd3-handle">
												Drag
											</div>
											<div class="dd3-content">
												{{$v2['display_name']}}
												
												<div class="pull-right">
													<div class="checkbox no-margin">
														<label>
														<a class="btn btn-xs btn-primary" href="{{route('permission.edit',['id'=>$v2['id']])}}"><span class="fa fa-pencil"></span></a>
														<a class="btn btn-xs btn-danger delete" href="javascript:;" data-href="{{route('permission.destroy',['id'=>$v2['id']])}}"><span class="fa fa-times"></span></a>
														</label>
													</div>
												</div>

											</div>
											
											@if(count($v2['child'])>0)
											<ol class="dd-list">
												@foreach($v2['child'] as $v3)
												<li class="dd-item dd3-item" data-id="{{$v['id']}}">
													<div class="dd-handle dd3-handle">
														Drag
													</div>
													<div class="dd3-content">
														{{$v3['display_name']}}
														
														<div class="pull-right">
															<div class="checkbox no-margin">
																<label>
																<a class="btn btn-xs btn-primary" href="{{route('permission.edit',['id'=>$v3['id']])}}"><span class="fa fa-pencil"></span></a>
																<a class="btn btn-xs btn-danger delete" href="javascript:;" data-href="{{route('permission.destroy',['id'=>$v3['id']])}}"><span class="fa fa-times"></span></a>
																</label>
															</div>
														</div>

													</div>
												</li>
												@endforeach
											</ol>
											@endif

										</li>
										@endforeach
									</ol>
									@endif
								</li>
								@endforeach
							</ol>
						</div>
					</div>
				</div>
			</div>
			<!-- end widget content -->

		</div>
		<!-- end widget div -->

	</div>
	<!-- end widget -->
</article>
@stop

@section('page-js-file')
<script src="/assets/admin/js/plugin/jquery-nestable/jquery.nestable.min.js"></script>
@stop

@section('page-script')
<script type="text/javascript">
	$(function(){
		$('#nestable3').nestable();
		// $('.dd').nestable('collapseAll');
	});
</script>
@stop