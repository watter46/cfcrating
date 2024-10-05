@php
    $svgSize = '
        w-[14px] h-[14px]
        xs:w-[16px] xs:h-[16px]
        md:w-[24px] md:h-[24px]
    ';
@endphp

@if($assists)
    <div class="flex justify-center space-x-[-10px]">
        @foreach(range(1, $assists) as $num)
            <div class="z-[{{ $loop->iteration }}] bg-white rounded-full assists p-0.5 {{ $svgSize }}">
                <x-svg.assist :class="$attributes['class']" />
            </div>
        @endforeach
    </div>
@endif