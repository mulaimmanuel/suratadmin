@extends('surats.layout')

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Form Elements</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Forms</li>
                <li class="breadcrumb-item active">Create Surat</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Form Create Surat</h5>

                            <form id="suratForm" action="{{ route('surats.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                    <select class="form-select" id="nomor_surat" name="nomor_surat">
                                        <option value="" disabled selected>Pilih Nomor Surat</option>
                                        <option value="ADDIR">ADDIR (Direksi)</option>
                                        <option value="HRGA">HRGA (HR)</option>
                                        <option value="ADADM">ADADM (Administrasi)</option>
                                    </select>
                                    <!-- Add a hidden input to store the selected value -->
                                    <input type="hidden" name="nomor_surat_hidden" id="nomor_surat_hidden" value="">
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea class="form-control" style="height: 100px" id="keterangan" name="keterangan"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_surat" class="form-label">Tanggal Surat</label>
                                    <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat">
                                </div>

                                <div class="mb-3">
                                    <label for="departemen" class="form-label">Departemen</label>
                                    <input type="text" class="form-control" id="departemen" name="departemen" readonly>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                                    <a href="{{ route('surats.index') }}" class="btn btn-danger">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var nomorSuratSelect = document.querySelector('#nomor_surat');
            var departemenInput = document.querySelector('#departemen');

            nomorSuratSelect.addEventListener('change', function() {
                var selectedValue = nomorSuratSelect.value;

                // Memetakan nilai departemen berdasarkan pilihan nomor surat
                var departemenMap = {
                    'ADDIR': 'Direksi',
                    'HRGA': 'HR',
                    'ADADM': 'Administrasi'
                };

                // Set the value of both 'departemen' and 'nomor_surat_hidden'
                departemenInput.value = departemenMap[selectedValue];
                departemenInput.setAttribute('readonly', 'readonly');
                $('#nomor_surat_hidden').val(selectedValue);
            });
        });
    </script>
    <script>
        function resetForm() {
            document.getElementById('suratForm').reset();
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#nomor_surat').change(function() {
                $('#nomor_surat_hidden').val($(this).val());
            });
        });
    </script>




</main><!-- End #main -->
@endsection