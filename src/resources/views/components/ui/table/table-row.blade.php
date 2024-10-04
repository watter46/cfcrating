<tr class="h-full" {{ $attributes }}>
    <td class="h-full px-6 py-4 text-base text-gray-300 whitespace-nowrap">
        {{ $column }}
    </td>
    <td class="h-full px-6 py-4 text-base text-gray-300 whitespace-nowrap">
        {{ $value }}
    </td>
    <td class="grid h-full grid-cols-3 p-3 space-x-2">
        @if(isset($action))
            {{ $action }}
        @else
            <p class="text-3xl text-gray-400">-</p>
        @endif
    </td>
</tr>