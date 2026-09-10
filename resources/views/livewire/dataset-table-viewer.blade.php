<div>
    @if (!empty($rows))
        <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="w-full text-left border-collapse">
                @foreach ($rows as $index => $row)
                    <tr class="{{ $index === 0 ? 'bg-slate-100 font-semibold text-slate-700 border-b border-gray-200' : 'border-b border-gray-100 hover:bg-slate-50 text-slate-600 text-sm' }}">
                        @foreach ($row as $cell)
                            @if ($index === 0)
                                <th class="p-3 border-r border-gray-200 last:border-r-0 whitespace-nowrap">{{ $cell }}</th>
                            @else
                                <td class="p-3 border-r border-gray-100 last:border-r-0">{{ $cell }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
    @else
        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 text-center text-slate-500 text-sm">
            Pratinjau tidak tersedia atau format file tidak didukung untuk tabel.
        </div>
    @endif
</div>
