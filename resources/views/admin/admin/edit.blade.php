@extends('layouts.admin.admin-master')

@section('breadcumb')
<!-- breadcrumb -->
<ol class="breadcrumb">
    <li>后台</li>
    <li>权限</li>
    <li>添加管理员</li>
</ol>
<!-- end breadcrumb -->
@stop

@section('content')
<article class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
	<div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false" data-widget-custombutton="false">
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
			<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
			<h2>添加管理员 </h2>				
			
		</header>
		<!-- widget div-->
		<div>
			
			<!-- widget edit box -->
			<div class="jarviswidget-editbox">
				<!-- This area used as dropdown edit box -->
				
			</div>
			<!-- end widget edit box -->
			
			<!-- widget content -->
			<div class="widget-body no-padding">
				
				<form id="form" class="smart-form" novalidate="novalidate" action="{{route('admins.update',['id'=>$admin->id])}}" method="POST">

					<fieldset>
						<div class="row">
							<section class="col col-md-12">
								<label class="label">管理员名称</label>
								<label class="input">
									<input type="text" class="validate[required]" name="name" value="{{$admin->name}}" placeholder="请输入英文名">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">管理员密码</label>
								<label class="input">
									<input type="password" class="validate[minSize[6]]" name="password" id="password1"  placeholder="为空表示不修改">
								</label>
							</section>
						</div>
						

					</fieldset>

					<fieldset>

							<section>
								<label class="label">角色</label>
								<div class="row">
									<?php 
										$role_ids=$admin->roles->pluck('id')->all();
									?>
									@foreach($roles->chunk(3) as $v)
										@foreach($v as $v2)
										<div class="col col-4">
											
											<label class="checkbox">
												<input type="checkbox" name="role[]" value="{{$v2->id}}" @if(in_array($v2->id,$role_ids)) checked="checked" @endif>
												<i></i>{{$v2->display_name}}</label>
												
										</div>
										@endforeach
									@endforeach
								</div>
							</section>
					
					</fieldset>
					<footer>
						{{method_field('PUT')}}
						{{csrf_field()}}
						<button type="submit" class="btn btn-primary">
							保存
						</button>
					</footer>
				</form>

			</div>
			<!-- end widget content -->
			
		</div>
		<!-- end widget div -->
	</div>
</article>
@stop