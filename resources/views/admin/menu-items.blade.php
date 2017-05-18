@foreach($items as $key=>$item)
    <li@lm-attrs($item) @lm-endattrs>
        @if($item->link)
            <a@lm-attrs($item->link) @lm-endattrs href="{!! $item->url() !!}">
                <span class="menu-content block">
                    <span class="menu-icon">@if($key == 0)<i class="block fa fa-home fa-lg"></i>@else<i class="block fa fa-list fa-lg"></i>@endif</span>
                    <span class="text m-left-sm">{!! $item->title !!}</span>
                    @if($item->hasChildren())<span class="submenu-icon"></span>@endif
                </span>
                <span class="menu-content-hover block">{!! $item->title !!}</span>
            </a>
        @else
            {!! $item->title !!}
        @endif
        @if($item->hasChildren())
            <ul class="submenu">
                @include('admin.submenu-items', array('items' => $item->children()))
            </ul>
        @endif
    </li>
    @if($item->divider)
        <li{!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
    @endif
@endforeach
