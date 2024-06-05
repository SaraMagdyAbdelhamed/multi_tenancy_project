<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-200">
        <tr>
            @foreach ($columns as $column)
                <th class="py-2 px-4">{{ $column }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
            <tr class="border-b">
                @foreach ($columns as $column)
                    <td class="py-2 px-4 text-center">{{ data_get($record, $column) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>