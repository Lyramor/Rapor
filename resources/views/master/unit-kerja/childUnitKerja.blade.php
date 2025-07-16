<tr>
    <td style="vertical-align: middle;">
        @if ($loop->depth > 0)
            <i class="fas fa-caret-right" style="margin-left: {{ ($loop->depth - 1) * 20 }}px;"></i>
        @endif
        {{ $unitkerja->kode_unit }}
    </td>
    <td style="text-align: center;vertical-align: middle;">{{ $unitkerja->nama_unit }}</td>
    <td style="text-align: center;vertical-align: middle;">{{ $unitkerja->parentUnit->nama_unit ?? '-' }}</td>
    <td style="text-align: center;vertical-align: middle;">
        <a href="{{ route('master.user.edit', $unitkerja->id) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit"></i>
        </a>
        {{-- detail button --}}
        <a href="{{ route('master.user.detail', $unitkerja->id) }}" class="btn btn-sm btn-info">
            <i class="fas fa-link"></i>
        </a>

        <form action="{{ route('master.user.delete', $unitkerja->id) }}" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger"
                onclick="return confirm('Anda yakin ingin menghapus role ini?')">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </td>
</tr>
{{-- Rekursi untuk child_unit --}}
@foreach ($unitkerja->childUnit as $childUnit)
    @include('master.unit-kerja.childUnitKerja', [
        'unitkerja' => $childUnit,
    ])
@endforeach
