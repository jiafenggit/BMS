@extends('layouts.admin.admin-master')

@section('breadcumb')
<!-- breadcrumb -->
<ol class="breadcrumb">
    <li>后台</li>
    <li>权限</li>
    <li>添加权限</li>
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
			<h2>添加权限 </h2>				
			
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
				
				<form id="form" class="smart-form" novalidate="novalidate" action="{{route('permission.store')}}" method="POST">

					<fieldset>
						<div class="row">
							<section class="col col-md-12">
								<label class="label">权限英文名</label>
								<label class="input">
									<input type="text" class="validate[required]" name="name" value="" placeholder="请输入英文名">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">权限中文名</label>
								<label class="input">
									<input type="text" class="validate[required]" name="display_name" value="" placeholder="请输入中文名称">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">URL</label>
								<label class="input">
									<input type="text" name="url" value="" placeholder="请输入URL 没有为空">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">父级权限</label>
								<label class="select">
									<select name="pid">
										<option value="0" selected="">无</option>
										@foreach($perms as $v)
										<option value="{{$v['id']}}">{{$v['html']}}{{$v['display_name']}}</option>
										@endforeach
									</select>
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">图标</label>
								<label class="input">
									<input type="text" name="icon" value="" placeholder="图标 例如 fa-home">
								</label>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-3">
								<label class="label">新窗口</label>
								<div class="inline-group">
									<label class="radio">
										<input type="radio" name="is_blank" value="1" >
										<i></i>是</label>
									<label class="radio">
										<input type="radio" name="is_blank" value="0" checked="checked">
										<i></i>否</label>
								</div>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-3">
								<label class="label">是否显示</label>
								<div class="inline-group">
									<label class="radio">
										<input type="radio" name="is_show" value="1" checked="checked">
										<i></i>是</label>
									<label class="radio">
										<input type="radio" name="is_show" value="0">
										<i></i>否</label>
								</div>
							</section>
						</div>

						<div class="row">
							<section class="col col-md-12">
								<label class="label">排序</label>
								<label class="input">
									<input type="text" class="validate[required]" name="rank" value="" placeholder="数字越小越靠前">
								</label>
							</section>
						</div>

					</fieldset>
					<footer>
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