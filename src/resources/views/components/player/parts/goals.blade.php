@props(['svgSize' => 'size-[14px] sm:size-[20px]'])

@if($goals)
    <div class="flex justify-center space-x-[-7px] sm:space-x-[-10px]">
        @foreach(range(1, $goals) as $num)
            <div class="z-[{{ $loop->iteration }}] bg-white rounded-full p-0.5 goals {{ $svgSize }}">
                <x-svg.goal />
            </div>
        @endforeach
    </div>
@endif