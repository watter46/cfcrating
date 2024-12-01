<li class="flex items-stretch text-white border-t-2 border-gray-800 min-h-28">
    <!-- TierTitle -->
    <div x-cloak
        x-data="initTierLabel('{{ $tier }}', '{{ $index }}')"
        class="flex-1 w-full min-w-28 my-handle">
        <textarea class="inline-flex items-center justify-center w-full h-full break-all resize-none"
            x-init="changeBackground($el), nonEditable($el)"
            maxlength="30"
            x-ref="inputField"
            x-model="tier"
            x-show="isEdit">
        </textarea>
            
        <p class="inline-flex items-center justify-center w-full h-full text-base text-center break-all"
            x-text="tier"
            x-show="!isEdit"
            x-init="changeBackground($el), editable($el)">
        </p>
    </div>

    <!-- itemList -->
    <div class="flex items-center w-full h-full px-2">
        <div id="tier-item" class="grid w-full h-full grid-cols-10 space-x-2" x-init="initDraggableItem($el)">
            
        </div>
    </div>
</li>