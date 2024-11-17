@props(['svgSize' => 'size-[14px] sm:size-[20px]'])

@if($assists)
    <div class="flex justify-center space-x-[-7px] sm:space-x-[-10px]">
        @foreach(range(1, $assists) as $num)
            <div class="z-[{{ $loop->iteration }}] bg-white rounded-full assists p-0.5 {{ $svgSize }}">
                <x-svg.assist />
            </div>
        @endforeach
    </div>
@endif