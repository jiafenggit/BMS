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
				
				<form id="form" class="smart-form" novalidate="novalidate" action="{{route('admins.store')}}" method="POST" enctype="multipart/form-data">

					<fieldset>
						<div class="row">
							<section class="col col-md-12">
								<label class="label">管理员名称</label>
								<label class="input">
									<input type="text" class="validate[required]" name="name" value="{{old('name','')}}" placeholder="请输入英文名">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">管理员密码</label>
								<label class="input">
									<input type="password" class="validate[required,minSize[6]]" name="password" id="password1" value="{{old('password','')}}" placeholder="请输入密码">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">确认密码</label>
								<label class="input">
									<input type="password" class="validate[required,equals[password1],minSize[6]]" name="password_confirmation" value="{{old('password_confirmation','')}}" placeholder="请输入确认密码">
								</label>
							</section>
						</div>

						

					</fieldset>

					<fieldset>

							<section>
								<label class="label">角色</label>
								<div class="row">
									@foreach($roles->chunk(3) as $v)
										@foreach($v as $v2)
										<div class="col col-4">
											
											<label class="checkbox">
												<input type="checkbox" name="role[]" value="{{$v2->id}}">
												<i></i>{{$v2->display_name}}</label>
												
										</div>
										@endforeach
									@endforeach
								</div>
							</section>
					
					</fieldset>
					<footer>
						{{csrf_field()}}
						<button type="submit" class="btn btn-primary">
							添加
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