@if($isImgLeft)
    <div {{ $attributes
        ->class("flex justify-start items-center")
        ->merge(['class' => $spaceSize]) }}>
        <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">

        @if ($isNameRequired)
            <p class="font-black text-gray-300 break-all text-start {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif
    </div>
@else
    <div {{ $attributes
        ->class("flex justify-end items-center")
        ->merge(['class' => $spaceSize]) }}>
        @if ($isNameRequired)
            <p class="font-black text-gray-300 break-all text-end {{ $textSize }}">
                {{ $team['name'] }}
            </p>
        @endif

        <img src="{{ asset($team['path']) }}" class="{{ $imgSize }}">
    </div>
@endif