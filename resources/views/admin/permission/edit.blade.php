@extends('layouts.admin.admin-master')

@section('breadcumb')
        <!-- breadcrumb -->
<ol class="breadcrumb">
    <li>后台</li>
    <li>权限</li>
    <li>编辑权限</li>
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
                <h2>编辑权限 </h2>

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

                    <form id="order-form" class="smart-form" novalidate="novalidate"
                          action="{{route('permission.update',['id'=>$perm->id])}}" method="POST">

                        <fieldset>
                            <div class="row">
                                <section class="col col-md-12">
                                    <label class="label">权限英文名</label>
                                    <label class="input">
                                        <input type="text" name="name" class="validate[required]"
                                               value="{{$perm->name}}">
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-md-12">
                                    <label class="label">权限中文名</label>
                                    <label class="input">
                                        <input type="text" name="display_name" class="validate[required]"
                                               value="{{$perm->display_name}}">
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-md-12">
                                    <label class="label">URL</label>
                                    <label class="input">
                                        <input type="text" name="url" value="{{$perm->url}}">
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-md-12">
                                    <label class="label">父级权限</label>
                                    <label class="select">
                                        <select name="pid">
                                            <option value="0" @if($perm->id==0) selected="selected" @endif >无</option>
                                            @foreach($perms as $v)
                                                <option value="{{$v['id']}}"
                                                        @if($v['id']==$perm->pid) selected="selected" @endif>{{$v['html']}}{{$v['display_name']}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                                <section class="col col-md-12">
                                    <label class="label">图标</label>
                                    <label class="input">
                                        <input type="text" name="icon" value="{{$perm->icon}}">
                                    </label>
                                </section>
                            </div>

                            <div class="row">
                            <section class="col col-md-3">
                                <label class="label">新窗口</label>
                                <div class="inline-group">
                                    <label class="radio">
                                        <input type="radio" name="is_blank" value="1" @if($perm->is_blank==1) checked="checked" @endif >
                                        <i></i>是</label>
                                    <label class="radio">
                                        <input type="radio" name="is_blank" value="0" @if($perm->is_blank==0) checked="checked" @endif >
                                        <i></i>否</label>
                                </div>
                            </section>
                        </div>

                        <div class="row">
                            <section class="col col-md-3">
                                <label class="label">是否显示</label>
                                <div class="inline-group">
                                    <label class="radio">
                                        <input type="radio" name="is_show" value="1" @if($perm->is_show==1) checked="checked" @endif>
                                        <i></i>是</label>
                                    <label class="radio">
                                        <input type="radio" name="is_show" value="0" @if($perm->is_show==0) checked="checked" @endif>
                                        <i></i>否</label>
                                </div>
                            </section>
                        </div>

                            <div class="row">
                                <section class="col col-md-12">
                                    <label class="label">排序</label>
                                    <label class="input">
                                        <input type="text" name="rank" class="validate[required]"
                                               value="{{$perm->rank}}">
                                    </label>
                                </section>
                            </div>

                        </fieldset>
                        <footer>
                            <input type="hidden" name="_method" value="PUT">
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