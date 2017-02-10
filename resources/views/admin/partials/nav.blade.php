<nav>
    <ul>
        <?php
        use App\Tools\Nav;

        $menus=Nav::menu(Auth::guard('admin')->id());

        // dd($menus);
        ?>

        @foreach($menus as $v)
            <li @if(!empty($v['url']) && Request::is(substr($v['url'],1).'*')) class="active"@endif>
                <a @if(count($v['child'])==0) href="{{$v['url']}}" @endif><i class="fa fa-lg fa-fw {{$v['icon']}}"></i> <span
                            class="menu-item-parent">{{$v['display_name']}}</span></a>
                @if(count($v['child'])>0)
                    <ul>
                        @foreach($v['child'] as $v2)
                            <li @if($v2['url'] !='' and Request::is(substr($v2['url'],1).'*')) class="active" @endif>
                                <a @if($v2['url'] !='') href="{{$v2['url']}}" @endif>{{$v2['display_name']}}</a>

                                @if(count($v2['child'])>0)
                                    <ul>
                                        @foreach($v2['child'] as $v3)
                                            <li @if(Request::is(substr($v3['url'],1).'*')) class="active" @endif>
                                                <a href="{{$v3['url']}}">{{$v3['display_name']}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
<span class="minifyme" data-action="minifyMenu">
	<i class="fa fa-arrow-circle-left hit"></i>
</span>