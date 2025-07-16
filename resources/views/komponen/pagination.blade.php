<!-- Tambahkan container untuk pagination di bawah tabel -->

<div id="pagination-container" class="">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-11">
                <div id="data-info">
                    @if (isset($total))
                        Total data: <span id="total-data">{{ $total }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-1">
                <div class="">
                    {{-- <label for="perPage" class="form-label">Data per Halaman:</label> --}}
                    <select id="perPage" class="form-select" onchange="location = this.value;">
                        @foreach ([10, 20, 50, 100] as $size)
                            <option value="{{ request()->fullUrlWithQuery(['perPage' => $size]) }}"
                                {{ request('perPage', 10) == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tempat untuk menampilkan pagination links -->
    <!-- Bagian tombol pagination pada tabel -->
    <ul class="pagination justify-content-md-end mt-3">
        <!-- Tombol Previous -->
        <li class="page-item {{ $data->currentPage() == 1 ? 'disabled' : '' }}">
            <a href="{{ $data->url(max(1, $data->currentPage() - 1)) }}" class="page-link">Previous</a>
        </li>

        <!-- Nomor Halaman -->
        @php
            $startPage = max(1, min($data->lastPage() - 9, $data->currentPage() - 4));
            $endPage = min($startPage + 9, $data->lastPage());
        @endphp
        @for ($i = $startPage; $i <= $endPage; $i++)
            <li class="page-item {{ $data->currentPage() == $i ? 'active' : '' }}">
                {{-- <a href="{{ $data->url($i) }}" class="page-link">{{ $i }}</a> --}}
                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="page-link">{{ $i }}</a>
            </li>
        @endfor

        <!-- Tombol Next -->
        <li class="page-item {{ $data->currentPage() == $data->lastPage() ? 'disabled' : '' }}">
            <a href="{{ $data->url(min($data->lastPage(), $data->currentPage() + 1)) }}" class="page-link">Next</a>
        </li>
    </ul>
</div>
