@php
    $svgSize = '
        w-[14px] h-[14px]
        sm:w-[20px] sm:h-[20px]
    ';
@endphp

@if($assists)
    <div class="flex justify-center space-x-[-7px] sm:space-x-[-10px]">
        @foreach(range(1, $assists) as $num)
            <div class="z-[{{ $loop->iteration }}] bg-gray-200 rounded-full assists p-0.5 {{ $svgSize }}">
                <x-svg.assist />
            </div>
        @endforeach
    </div>
@endif