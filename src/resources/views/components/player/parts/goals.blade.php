@php
    $svgSize = '
        w-[14px] h-[14px]
        sm:w-[20px] sm:h-[20px]
    ';
@endphp

@if($goals)
    <div class="flex justify-center space-x-[-7px] sm:space-x-[-10px]">
        @foreach(range(1, $goals) as $num)
            <div class="z-[{{ $loop->iteration }}] bg-gray-200 rounded-full p-0.5 goals {{ $svgSize }}">
                <x-svg.goal />
            </div>
        @endforeach
    </div>
@endif