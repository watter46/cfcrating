@php
    $svgSize = '
        w-[14px] h-[14px]
        md:w-[24px] md:h-[24px]
    ';
@endphp

@if($goals)
    <div class="flex justify-center space-x-[-10px]">
        @foreach(range(1, $goals) as $num)
            <div class="z-[{{ $loop->iteration }}] bg-white rounded-full p-0.5 {{ $svgSize }}">
                <x-svg.goal :class="$attributes['class']" />
            </div>
        @endforeach
    </div>
@endif