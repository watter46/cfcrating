<div class="flex flex-col items-center justify-center w-full gap-y-1.5" x-cloak>
    <label class="w-full text-sm font-black text-gray-400 text-start md:text-xl">Rating Switch</label>
    <ul class="flex w-full gap-6">
        <li class="grow">
            <input type="radio" id="my" name="my" value="my" class="hidden peer" wire:model.live="toggleStates">
            <label for="my" class="inline-flex items-center justify-between w-full p-2 text-gray-400 bg-gray-800 border border-gray-700 rounded-lg cursor-pointer hover:text-gray-300 peer-checked:text-blue-500 peer-checked:border-blue-600 hover:bg-gray-700">
                <div class="block">
                    <div class="w-full text-xs md:text-lg">My</div>
                </div>
                <x-svg.user class="w-4 h-4 md:w-5 md:h-5 fill-[#6B7280]" />
            </label>
        </li>

        <li class="grow">
            <input type="radio" id="users" name="users" value="users" class="hidden peer"
            wire:model.live="toggleStates">
            <label for="users" class="inline-flex items-center justify-between w-full p-2 text-gray-400 bg-gray-800 border border-gray-700 rounded-lg cursor-pointer hover:text-gray-300 peer-checked:text-blue-500 peer-checked:border-blue-600 hover:bg-gray-700">
                <div class="block">
                    <div class="w-full text-xs md:text-lg">Users</div>
                </div>
                <x-svg.users class="w-4 h-4 md:w-5 md:h-5 fill-[#6B7280]" />
            </label>
        </li>

        <li class="grow">
            <input type="radio" id="machine" name="machine" value="machine" class="hidden peer"
            wire:model.live="toggleStates" />
            <label for="machine" class="inline-flex items-center justify-between w-full p-2 text-gray-400 bg-gray-800 border border-gray-700 rounded-lg cursor-pointer hover:text-gray-300 peer-checked:text-blue-500 peer-checked:border-blue-600 hover:bg-gray-700">                           
                <div class="block">
                    <div class="w-full text-xs md:text-lg">Machine</div>
                </div>
                <x-svg.machine class="w-4 h-4 md:w-5 md:h-5 fill-[#6B7280]" />
            </label>
        </li>
    </ul>
</div>