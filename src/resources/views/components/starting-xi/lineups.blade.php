<div x-data="initLineups(@js($players))"
    x-init="lineups = defaultLineups()"
    class="relative flex flex-col justify-center w-full px-1 mx-auto lg:flex-row lg:space-x-20">

    <div id="starting-xi" class="w-full max-w-[600px]">
        <!-- Title -->
        <div class="w-full px-2 min-h-10 max-h-20" x-cloak x-show="title">
            <p class="w-full h-full text-2xl italic font-black text-white break-all sm:text-4xl" x-text="title"></p>
        </div>

        <div class="flex justify-end w-full px-2">
            <div class="flex flex-col justify-center">
                <x-util.cfc-rating-icon class="h-4 sm:h-6" />
                <p class="text-xs font-black text-center text-gray-400 sm:text-base">@cfcRating</p>
            </div>
        </div>

        <!-- StartingXiField -->
        <div id="starting-xi-field" class="relative flex flex-col items-center justify-center w-full">
            <!-- FieldImage -->
            {{ $slot }}

            <!-- StartXI -->
            <div class="absolute w-full h-full startXI">
                <div class="flex items-end justify-center w-full h-full">
                    <div class="flex flex-col w-full h-full">
                        <template x-for="players in lineups">
                            <div class="flex items-center justify-center w-full h-full">
                                <template x-for="player in players">
                                    <div class="flex items-center justify-center flex-1">
                                        <div class="relative flex items-center justify-center bg-gray-600 rounded-full cursor-pointer draggable player-size"
                                            :data-position-id="player.positionId"
                                            x-init="initDraggable($el)">

                                            <template x-if="!player.isSelected">
                                                <x-svg.cross class="rotate-45 size-8 fill-gray-400" />
                                            </template>

                                            <template x-if="player.isSelected">
                                                <div class="flex items-center justify-center">
                                                    <div class="relative flex items-center justify-center rounded-full player-image">
                                                        <img alt="player-image" class="rounded-full" :src="player.data?.path">

                                                        <p class="absolute text-lg font-black text-white"
                                                            x-show="!player.data?.pathExist"
                                                            x-text="player.data?.number"></p>

                                                        <p class="absolute text-xs font-black md:text-xl text-center bg-[#01142E] text-white top-full"
                                                            x-text="player.data?.name"></p>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- CrIcon -->
            <x-util.cr-icon class="absolute bottom-0 size-8 sm:size-12 left-2" />
        </div>
    </div>

    <!-- PlayersModal -->
    <x-ui.modal.modal
        name="startingxi"
        x-data="{ name: 'startingxi', positionId: null }"
        @open-modal-startingxi.window="positionId = event.detail">
        <div class="w-full h-full mb-10 space-y-1">
            <div class="flex items-center justify-center space-x-2">
                <button class="flex items-center px-2 py-1 space-x-1 bg-gray-700 rounded-lg w-fit"
                    @click="clear(positionId)">
                    <x-svg.refresh class="size-5 stroke-gray-400" />

                    <p class="text-sm font-black text-gray-400">Clear</p>
                </button>
            </div>

            <template x-for="player in playersData">
                <div class="relative flex items-center p-1 border-b border-gray-700"
                    @click="select(positionId, player.id)">
                    <div class="flex items-center justify-center">
                        <div class="size-6">
                            <x-svg.remaining-count
                                class="rotate-90 fill-white size-full"
                                x-show="isSelected(player.id)" />
                        </div>

                        <div class="flex items-center space-x-2">
                            <div class="relative flex items-center justify-center rounded-full size-10 player-image">
                                <img alt="player-image" :src="player.path" class="rounded-full">

                                <p class="absolute text-lg font-black text-white"
                                    x-show="!player.pathExist"
                                    x-text="player.number"></p>
                            </div>

                            <div class="flex flex-col justify-center">
                                <p x-data="{ position: player.position }" class="text-sm font-black"
                                    x-text="position"
                                    x-init="positionColor($el, position)">
                                </p>
                                <p class="text-center text-white" x-text="player.number ?? '-'"></p>
                            </div>

                            <p class="text-white" x-text="player.fullName"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </x-ui.modal.modal>

    <div class="flex justify-center w-full lg:max-w-sm">
        <div class="flex flex-col justify-center w-full mt-3 space-y-3">
            <section class="flex items-center justify-end">
                <!-- Formation-->
                <div class="flex flex-col items-center w-full">
                    <p class="w-full text-lg font-black text-white">Formation</p>
                    <div class="flex items-center w-full space-x-3">
                        <form x-data="initFormation()" class="w-full">
                            <label for="formation"></label>
                            <select id="formation" class="block w-full max-w-xs px-2 text-sm text-white placeholder-gray-400 bg-gray-700 border border-gray-600 rounded-lg sm:text-lg focus:ring-blue-500 focus:border-blue-500"
                                x-model="formation" @change="lineups = changeFormation(lineups, formation)">
                                <template x-for="formation in list">
                                    <option x-text="formation" :selected="isInitFormation(formation)"></option>
                                </template>
                            </select>
                        </form>

                        <div class="flex flex-col items-center justify-center w-fit">
                            <button class="relative flex items-center px-2 py-1 bg-gray-700 rounded-lg w-fit"
                                @click="$dispatch('reset-all-positions')">
                                <x-svg.refresh class="size-7 sm:size-10 stroke-gray-400" />

                                <p class="absolute left-0 w-full text-xs font-black text-center text-gray-400 top-full sm:text-base">
                                    Reset
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TitleInput -->
            <section x-data="initStartingXiTitle()">
                <label for="starting-xi-title" class="block text-sm font-black text-white sm:text-lg">Title</label>
                <input id="starting-xi-title" class="w-full text-[16px] bg-gray-700 border-gray-600 font-black text-white break-all rounded-md resize-none sm:text-lg"
                    maxlength="20"
                    x-ref="inputField"
                    x-model="title"
                    x-init="nonEditable($el)" />
            </section>

            <!-- Download -->
            <x-starting-xi.download-button>
                <x-svg.download class="w-5 h-5 stroke-gray-200" />
            </x-starting-xi.download-button>
        </div>
    </div>
</div>

@vite([
    'resources/js/startingXi/startingXi.js',
    'resources/js/startingXi/draggable.js',
    'resources/js/startingXi/title.js',
    'resources/css/player.css',
    'resources/css/startingXi.css'
])
