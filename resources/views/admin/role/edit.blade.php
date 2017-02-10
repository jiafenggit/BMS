@extends('layouts.admin.admin-master')

@section('breadcumb')
<!-- breadcrumb -->
<ol class="breadcrumb">
    <li>后台</li>
    <li>权限</li>
    <li>编辑角色</li>
</ol>
<!-- end breadcrumb -->
@stop

@section('content')
<article class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
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
			<h2>编辑角色 </h2>				
			
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
				
				<form id="form" class="smart-form" novalidate="novalidate" action="{{route('role.update',['id'=>$role->id])}}" method="POST">
					<div class="col-md-4">
						<fieldset>
							<div class="row">
								<section class="col col-md-12">
									<label class="label">角色名称</label>
									<label class="input">
										<input type="text" class="validate[required]" name="display_name" value="{{$role->display_name}}" placeholder="请输入角色名称">
									</label>
								</section>
							</div>

							<div class="row">
								<section class="col col-md-12">
									<label class="label">角色英文</label>
									<label class="input">
										<input type="text" class="" name="name" value="{{$role->name}}" placeholder="请输入角色英文名称">
									</label>
								</section>
							</div>

							<div class="row">
								<section class="col col-md-12">
									<label class="label">角色描述</label>
									<label class="input">
										<input type="text" class="" name="description" value="{{$role->description}}" placeholder="请输入角色描述">
									</label>
								</section>
							</div>

						</fieldset>
					</div>
					
					<div class="col-md-8">
						<fieldset>

							<section>
								<label class="label">权限</label>
								<div class="row">
									<?php 
										$perm_ids=$role->perms->pluck('id')->all();
									?>
									<div class="col col-4">
										@foreach($perms as $v)
										<label class="checkbox">
											{{$v['html']}}<input type="checkbox" name="permission[]" value="{{$v['id']}}" @if(in_array($v['id'],$perm_ids)) checked="checked" @endif>
											<i></i>{{$v['display_name']}}</label>
										@endforeach
									</div>
								</div>
							</section>
					
						</fieldset>
					</div>
					
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