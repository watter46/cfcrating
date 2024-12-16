<section x-cloak x-data="initTierTitle()"
    class="flex-1 w-full h-full">
    <input class="w-full text-3xl text-white break-all bg-transparent resize-none"
        maxlength="40"
        x-ref="inputField"
        x-model="title"
        x-show="isEdit"
        x-init="nonEditable($el)" />
        
    <p class="w-full h-full text-3xl text-white break-all"
        x-text="title"
        x-show="!isEdit"
        x-init="editable($el)">
    </p>
</section>