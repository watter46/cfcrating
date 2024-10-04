<div {{ $attributes->class(['container p-6 mx-auto']) }}>
    <p class="py-2 text-2xl font-black text-gray-300">{{ $table }} Table</p>
    
    <div class="overflow-x-auto rounded-md">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-teal-700">
                <tr>
                    <th class="w-1/12 px-6 py-3 text-base font-black tracking-wider text-left text-gray-300 uppercase">
                        Column
                    </th>
                    <th class="w-8/12 px-6 py-3 text-base font-black tracking-wider text-left text-gray-300 uppercase">
                        Value
                    </th>
                    <th class="w-3/12 px-6 py-3 text-base font-black tracking-wider text-left text-gray-300 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            
            <tbody class="bg-teal-800 divide-y divide-gray-200">
                {{ $tableBody }}
            </tbody>
        </table>

        <!-- SaveButton -->
        <div class="flex justify-end w-full py-2">
            {{ $saveBtn }}
        </div>
    </div>
</div>