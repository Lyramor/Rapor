<select id="programstudi" class="form-select" aria-label="Default select example" name="programstudi">
    {{-- @foreach ($unitkerja as $unit) --}}
    <option value="{{ $unitkerja->id }}">
        {{ $unitkerja->nama_unit }}</option>
    @if ($unitkerja->jenis_unit == 'FAKULTAS')
        @foreach ($unitkerja->childUnit as $child)
            <option value="{{ $child->id }}">&nbsp;&nbsp;
                {{ $child->nama_unit }}</option>
        @endforeach
    @endif

    {{-- @if ($unitkerja->jenis_unit == 'Program Studi')
        <option value="{{ $unitkerja->id }}">
            {{ $unitkerja->nama_unit }}</option>
    @endif --}}
</select>
