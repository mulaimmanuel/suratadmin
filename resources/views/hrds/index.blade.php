@extends('surats.layout')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Data</li>
            </ol>
        </nav>

    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List Data Surat</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nomor Surat</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Tanggal Surat</th>
                                    <th scope="col">Departemen</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surats as $surat)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $surat->nomor_surat }}</td>
                                    <td>{{ $surat->keterangan }}</td>
                                    <td>{{ $surat->tanggal_surat }}</td>
                                    <td>{{ $surat->departemen }}</td>
                                    <td>{{ $surat->created_at }}</td>
                                    <td>{{ $surat->updated_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {!! $surats->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>


</main><!-- End #main -->
@endsection