@foreach($items as $key=>$item)
    <li@lm-attrs($item) @lm-endattrs>
        @if($item->link)
            <a href="{!! $item->url() !!}">
                <span class="submenu-label">{!! $item->title !!}</span>
                <small class="badge badge-success badge-square bounceIn animation-delay2 m-left-xs pull-right"></small>
            </a>
        @else
            {!! $item->title !!}
        @endif
        @if($item->hasChildren())
            <ul class="submenu  third-level">
                @include('admin.submenu-third-level', array('items' => $item->children()))
            </ul>
        @endif
    </li>
    @if($item->divider)
        <li{!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
    @endif
@endforeach
