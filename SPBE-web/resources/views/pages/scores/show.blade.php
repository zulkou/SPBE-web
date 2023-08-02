<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="score"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Score"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <h6 class="text-white text-capitalize ps-3">Penilaian</h6>
                                    <div class="ms-md-auto px-3 mb-2 me-2 d-flex">
                                        <label for="filterYear" class="my-auto me-2 text-white text-capitalize ps-3">Filter Tahun</label>
                                        <div class="form-group mt-2 px-3" style="background-color: white; border-radius: 8px;">
                                            <select id="filterYear" class="form-control">
                                                <option value="">Semua Tahun</option>
                                                @php
                                                    $uniqueYears =[];
                                                @endphp
                                                @foreach($attributes as $attribute)
                                                    @php
                                                        $year = date('Y', strtotime($attribute->updated_at));
                                                    @endphp
                                                    @if (!in_array($year, $uniqueYears))
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @php
                                                            $uniqueYears[] = $year; // Tambahkan tahun ke array jika belum ada
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tahun</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nama Indikator</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                >
                                                Score</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                colspan="">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $uniqueIndicators = [];
                                        @endphp
                                        @forelse ($attributes as $attribute)
                                            @php
                                                $year = date('Y', strtotime($attribute->updated_at));
                                                $indicatorName = $attribute->indicator_name;
                                            @endphp
                                            @if (!in_array($indicatorName, $uniqueIndicators))
                                                @php
                                                    $uniqueIndicators[] = $indicatorName; // Tambahkan nama indikator ke array jika belum ada
                                                @endphp
                                            <tr class="data-row" data-year="{{ $year }}">
                                                {{-- Year --}}
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ date('Y', strtotime($attribute->updated_at)) }}</span>
                                                </td>
                                                {{-- Indicator --}}
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $indicatorName}}</span>
                                                </td>
                                                {{-- Score --}}
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold">{{ $attribute->score}}</span>
                                                </td>
                                                {{-- Beri Penilaian --}}
                                                <td class="w-10">
                                                    <div class="align-middle text-center">
                                                        <a href="javascript:;" class="link-info font-weight-bold text-xs"
                                                            style="cursor: pointer" data-bs-toggle="modal"
                                                            data-bs-target="#detailModal{{ $attribute->id }}"
                                                            data-original-title="Edit user">
                                                            Beri Penilaian
                                                        </a>
                                                    </div>
                                                    <!-- Modal Beri Penilaian -->
                                                    <div class="modal fade" id="detailModal{{ $attribute->id }}"
                                                        tabindex="-1" aria-labelledby="detailModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailModalLabel">Beri
                                                                        Penilaian</h5>
                                                                    <button type="button" style="align-self: flex-start; margin: 0;"
                                                                        class="btn-close btn-close-white  "
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="row mb-3">
                                                                                <div class="col-sm-3 text-start fw-bold">Domain</div>
                                                                                {{-- <div class="col-sm-auto fw-bold">:</div> --}}
                                                                                <div class="col-sm-8">{{ $attribute->domain_name }}</div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-sm-3 text-start fw-bold">Aspek</div>
                                                                                {{-- <div class="col-sm-auto fw-bold">:</div> --}}
                                                                                <div class="col-sm-8">{{ $attribute->aspect_name }}</div>
                                                                            </div>
                                                                            <div class="row mb-3">
                                                                                <div class="col-sm-3 text-start fw-bold">Indikator</div>
                                                                                {{-- <div class="col-sm-auto fw-bold">:</div> --}}
                                                                                <div class="col-sm-8">{{ $attribute->indicator_name }}</div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <form action="{{ route('score.update', ['indicator' => $attribute->id]) }}" method="POST">
                                                                    <div class="modal-body">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-sm-3 text-start fw-bold">Tingkat Capaian</div>
                                                                                {{-- <div class="col-sm-auto fw-bold"></div> --}}
                                                                                <div class="col-sm-8">
                                                                                    <select id="score" name="score"
                                                                                        class="form-control border border-2 p-2">
                                                                                            <option value=""></option>
                                                                                            <option value="1">Sangat Kurang</option>
                                                                                            <option value="2">Kurang</option>
                                                                                            <option value="3">Cukup</option>
                                                                                            <option value="4">Baik</option>
                                                                                            <option value="5">Sangat Baik</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-sm-3 text-start fw-bold">Penjelasan Indikator</div>
                                                                                <div class="col-sm-auto fw-bold">:</div>
                                                                                <div class="col-sm-5">{{ $attribute->description }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <hr>
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-sm-3 text-start fw-bold">Daftar Data Dukung</div>                                                                            </div>
                                                                        <ul>
                                                                            @foreach ($attribute->documents as $document)
                                                                                @if (! is_null($document->upload_path))
                                                                                    <li>
                                                                                        <a class="link-info" href="{{ $document->file_path_url }}" target="_blank">
                                                                                            {{ $document->doc_name }}
                                                                                        </a>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <span class='text-secondary fw-bold'>
                                                                                            {{ $document->doc_name }} <span style="color:red;">(Belum Upload)</span>
                                                                                        </span>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @empty
                                            <div class='alert alert-danger'>
                                                Tidak ada data
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        <div class="container mt-3">
                            {{ $attributes->onEachSide(2)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Tambahkan stylesheet TinyMCE (jika menggunakan CDN) -->
        <script src="https://cdn.tiny.cloud/1/m5qijcc36wgnreuxu9sqpw3jsaelf3euqu4gsb85pn56ti5w/tinymce/5/tinymce.min.js">
        </script>
        <script>
            tinymce.init({
                selector: '#descriptionEdit',
                plugins: 'advlist autolink lists link image charmap print preview anchor textcolor',
                toolbar: 'undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
            });
            @foreach ($attributes as $attribute)
                tinymce.init({
                    selector: '#descriptionEdit2_{{ $attribute->id }}',
                    plugins: 'advlist autolink lists link image charmap print preview anchor textcolor',
                    toolbar: 'undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                });
            @endforeach
        </script>
    </main>
    <x-plugins></x-plugins>
    @push('js')
        <script>
            //message with toastr
            @if (session()->has('success'))

                toastr.success('{{ session('success') }}', 'BERHASIL!');
            @elseif (session()->has('error'))

                toastr.error('{{ session('error') }}', 'GAGAL!');
            @endif
        </script>
        <script>
            const filterYearSelect = document.getElementById('filterYear');
            const yearDataRows = document.querySelectorAll('.data-row');

            filterYearSelect.addEventListener('change', function() {
                const selectedYear = this.value;

                if (selectedYear === '') {
                    yearDataRows.forEach(row => {
                        row.style.display = 'table-row';
                    });
                } else {
                    yearDataRows.forEach(row => {
                        const rowYear = row.getAttribute('data-year');
                        if (rowYear === selectedYear) {
                            row.style.display = 'table-row';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            });
        </script>
    @endpush

</x-layout>