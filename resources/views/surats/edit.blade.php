@extends('surats.layout')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Form Edit</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="container-fluid"> <!-- Menggunakan container-fluid untuk membuat konten memenuhi lebar layar -->
            <div class="row">
                <div class="col-lg-12"> <!-- Menggunakan col-lg-12 agar formulir menggunakan seluruh lebar layar -->

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">General Form Elements</h5>
                            <form id="suratForm" action="{{ route('surats.update', $surat->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="nomor_surat" class="col-sm-2 col-form-label">Nomor Surat</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="nomor_surat">
                                            <option value="" disabled>Pilih Nomor Surat</option>
                                            <option value="ADDIR" {{ $surat->nomor_surat == 'ADDIR' ? 'selected' : '' }}>ADDIR (Direksi)</option>
                                            <option value="HRGA" {{ $surat->nomor_surat == 'HRGA' ? 'selected' : '' }}>HRGA (HR)</option>
                                            <option value="ADADM" {{ $surat->nomor_surat == 'ADADM' ? 'selected' : '' }}>ADADM (Administrasi)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" style="height: 100px" id="keterangan" name="keterangan">{{ $surat->keterangan }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="tanggal_surat" class="col-sm-2 col-form-label">Tanggal Surat</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ $surat->tanggal_surat }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="departemen" class="col-sm-2 col-form-label">Departemen</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="departemen" name="departemen" value="{{ $surat->departemen }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                                        <a href="{{ route('surats.index') }}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ... Bagian HTML yang sudah ada ... -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var nomorSuratSelect = document.querySelector('select[name="nomor_surat"]');
            var departemenInput = document.querySelector('input[name="departemen"]');

            // Peta nilai departemen berdasarkan nomor surat
            var departemenMap = {
                'ADDIR': 'Direksi',
                'HRGA': 'HR',
                'ADADM': 'Administrasi'
            };

            // Inisialisasi nilai departemen saat halaman dimuat
            departemenInput.value = departemenMap[nomorSuratSelect.value];

            // Tambahkan event listener untuk mengubah nilai departemen saat pilihan nomor surat berubah
            nomorSuratSelect.addEventListener('change', function() {
                var selectedValue = nomorSuratSelect.value;

                // Set nilai departemen sesuai dengan pilihan nomor surat
                departemenInput.value = departemenMap[selectedValue];
            });
        });
    </script>

    <script>
        function resetForm() {
            document.getElementById('suratForm').reset();
        }
    </script>

    <!-- ... Bagian HTML yang sudah ada ... -->


</main><!-- End #main -->
@endsection