<!-- Download -->
<section id="tier-download" class="fixed inset-0 z-[-100]"></section>

<div id="tier" class="px-1" x-data="tierListData({{ $maxCount }})" x-init="initTierList()">
    <section id="tier-content" class="relative">
        <x-ui.background.medium />

        <!-- Tier Header -->
        <section class="flex items-center justify-between w-full space-x-2">
            <!-- Title -->
            <div class="w-3/4 px-2 min-h-10 max-h-20" x-cloak>
                <p class="w-full h-full text-2xl italic font-black text-white break-all sm:text-4xl"
                    x-text="title"
                    x-show="title">
                </p>
            </div>
        
            <!-- Logo -->
            <div class="flex flex-col items-center px-5">
                <img src="{{ asset('storage/background/app-logo.svg') }}" class="h-6">
                <p class="hidden text-xl font-black text-gray-400 md:block">@cfcRating</p>
            </div>
        </section>
        
        <!-- Tier List -->
        <ul id="tier-list" x-init="initDraggableList($el)">
            <template x-for="row in rows" :key="row.id" x-ref="list">
                <li :data-id="row.id" class="flex items-stretch h-full overflow-hidden text-white border-t-2 border-gray-800 max-w-screen min-h-28 tier-list">

                    <!-- TierTitle -->
                    <div class="min-w-20 sm:min-w-28 my-handle tier_title">
                        <p class="inline-flex items-center justify-center w-full h-full text-base text-center text-white break-all tier_title_text" x-text="row.title"
                            :id="`row-title-${row.id}`"
                            :style="`background-color: ${row.bg}`">
                        </p>
                    </div>

                    <!-- itemList -->
                    <div class="flex items-stretch w-full">
                        <!-- DragArea -->
                        <div class="flex flex-wrap w-full gap-1 tier-item-list"
                            x-init="initDraggableItem($el)"></div>

                        <!-- Setting -->
                        <div class="flex items-center text-white bg-gray-600 cursor-pointer tier-setting"
                            @click="$dispatch('open-modal-tier-setting', row)">
                            <x-svg.setting class="size-6 sm:size-8 fill-white" />
                        </div>
                    </div>
                </li>
            </template>

            <!-- SettingModal -->
            <x-ui.modal.modal id="setting-modal" name="tier-setting">
                <div class="w-full h-full p-2 mt-3 space-y-10"
                    x-data="settingModalData()"
                    @open-modal-tier-setting.window="setTierData(event.detail)">
                    
                    <!-- BackgroundColor -->
                    <div class="space-y-2">
                        <p class="text-xl font-black text-white">Color</p>

                        <div class="grid grid-cols-6 gap-2">
                            <template x-for="color in colors">
                                <span class="rounded-full size-8"
                                    :class="isCurrentColor(color) && 'border border-white'"
                                    :style="`background-color: ${color}`"
                                    @click="selectColor(color)">
                                </span>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Title Textarea -->
                    <div class="space-y-2">
                        <label for="edit-tier-title">
                            <p class="text-xl font-black text-white">Title</p>
                        </label>
                        <textarea id="edit-tier-title"
                            class="w-full font-black text-white break-all bg-transparent rounded-md resize-none"
                            maxlength="30"
                            required
                            x-show="title"
                            x-model="title">
                        </textarea>
                    </div>

                    <div class="flex flex-col justify-center w-full space-y-8 sm:space-y-0 sm:flex-row sm:justify-around">
                        <button class="w-full px-3 py-1 bg-blue-600 rounded-md sm:w-40 hover:bg-blue-500"
                            @click="edit()">
                            <div class="flex items-center justify-center space-x-2">
                                <p class="text-lg font-black text-white">Edit</p>
                            </div>
                        </button>
                        
                        <button class="w-full px-3 py-1 bg-red-600 rounded-md sm:w-40 hover:bg-red-500"
                            @click="remove()">
                            <div class="flex items-center justify-center space-x-2">
                                <p class="text-lg font-black text-white">Remove</p>
                            </div>
                        </button>
                    </div>
                </div>
            </x-ui.modal.modal>
        </ul>
    </section>

    <!-- AddTierModal -->
    <x-ui.modal.modal id="add-tier-modal" name="add-tier">
        <div class="w-full h-full p-2 mt-3 space-y-10 sm:px-10" x-data="addTierModalData()">
            <p class="text-2xl font-black text-gray-400">NewTier</p>
            
            <!-- BackgroundColor -->
            <div class="space-y-2">
                <p class="text-xl font-black text-gray-400">Color</p>

                <div class="grid grid-cols-6 gap-2">
                    <template x-for="color in colors">
                        <span class="rounded-full cursor-pointer size-8"
                            :class="isCurrentColor(color) && 'border border-white'"
                            :style="`background-color: ${color}`"
                            @click="selectColor(color)">
                        </span>
                    </template>
                </div>
            </div>
            
            <!-- Title Textarea -->
            <div class="space-y-2">
                <label for="add-tier-title">
                    <p class="text-xl font-black text-gray-400">Title</p>
                </label>
                <textarea id="add-tier-title"
                    class="w-full font-black text-white break-all bg-transparent rounded-md resize-none"
                    maxlength="30"
                    required
                    x-model="newTitle">
                </textarea>
            </div>

            <div class="flex justify-center w-full">
                <button class="relative w-40 px-3 py-1 bg-gray-600 rounded-md hover:bg-gray-500" @click="add()"
                    :class="isZero() && 'opacity-60 pointer-events-none'">
                    <span class="absolute inline-flex items-center justify-center px-1.5 text-sm font-black text-white bg-red-700 rounded-full -left-2 -top-2" x-text="remainingCount">
                    </span>

                    <div class="relative flex items-center justify-center space-x-2">
                        <x-svg.plus class="absolute left-0 size-6 fill-white" />
                        <p class="text-lg font-black text-white">Add</p>
                    </div>
                </button>
            </div>
        </div>
    </x-ui.modal.modal>

    <!-- Option -->
    <div id="tier-option" class="flex justify-end w-full mt-3 space-x-7">
        <div class="flex flex-col justify-center">
            <button class="relative self-center size-10" @click="$dispatch('open-modal-add-tier')">
                <span class="absolute inline-flex items-center justify-center px-1.5 text-sm font-black text-white bg-red-700 rounded-full -left-2 -top-2" x-text="remainingCount">
                </span>
                
                <x-svg.plus class="self-center size-full fill-gray-400 hover:fill-gray-300" />
            </button>

            <p class="w-full text-xs font-black text-center text-gray-400">Add Tier</p>
        </div>
    </div>

    <div id="tier-buttons" class="flex justify-center w-full mt-3">
        <div class="flex flex-col justify-center w-full max-w-lg space-y-3">
            <!-- TitleInput -->
            <section class="w-full max-w-lg">
                <label for="starting-xi-title" class="block text-sm font-black text-white sm:text-lg">Title</label>
                <input id="starting-xi-title" class="w-full text-sm font-black text-white break-all bg-transparent rounded-md resize-none sm:text-lg"
                    maxlength="20"
                    x-model="title" />
            </section>
            
            <!-- Download -->
            <x-ui.button.flow-button
                before="'Download'"
                after="'Downloaded!!'"
                method="'downloadTierImage'"
                color="#16a34a">
                <x-svg.download class="w-5 h-5 stroke-gray-200" />
            </x-ui.button.flow-button>
        </div>
    </div>
</div>

@vite([
    'resources/js/tier/draggable.js',
    'resources/js/tier/tierList.js',
    'resources/js/tier/setting.js'
])