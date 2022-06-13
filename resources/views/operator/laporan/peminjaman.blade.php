@extends('layouts.layout')
@section('location','Dashboard')
@section('location2')
    <i class="fa fa-dashboard"></i>&nbsp;Laporan Transaksi Peminjaman
@endsection
@section('user-login','Operator')
@section('sidebar-menu')
    @include('operator/sidebar')
@endsection
@section('content')
    <div class="callout callout-info ">
        <h4>Perhatian!</h4>
        <p>
            Berikut adalah data transaksi peminjaman barang yang sudah tersedia, silahkan cetak dalam bentuk excel/pdf
            <br>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar"></i>&nbsp;Laporan Transaksi Peminjaman</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <i class="fa fa-success-circle"></i><strong>Berhasil :</strong> {{ $message }}
                        </div>
                    @endif
                    @if($message2 = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>Gagal :</strong> {{ $message2 }}
                        </div>
                    @endif
                    <form action="{{ route('laporan.cari_pinjam') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Dari Tanggal</label>
                                <input type="date" class="form-control" name="dari_tanggal" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sampai Tanggal</label>
                                <input type="date" class="form-control" name="sampai_tanggal" required>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>&nbsp; Cari</button>
                            </div>
                        </div>
                    </form>

                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" id="kelas">
                                <thead class="bg-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Pinjam</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @forelse ($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $transaksi->tanggal_pinjam }}</td>
                                        <td>{{ $transaksi->kode_barang }}</td>
                                        <td>{{ $transaksi->nama_barang }}</td>
                                        <td>{{ $transaksi->jumlah_pinjam }}</td>
                                        <td>{{ $transaksi->nama_peminjam }}</td>
                                        <td>{{ $transaksi->tanggal_kembali }} </td>
                                        <td>
                                            @if ($transaksi->keterangan == "sedang_dipinjam")
                                                <label class="text-warning"><i class="fa fa-clock-o"></i>&nbsp; Sedang Dipinjam</label>
                                            @else
                                                <label class="text-success"><i class="fa fa-check-circle"></i>&nbsp; Sudah Dikembalikan</label>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center"><label class="text-danger">Data Transaksi Keluar Tidak Tersedia</label></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                 </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#kelas').DataTable( {
            buttons: [ 'excel', 'pdf' ],
            dom:
            "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
            "<'row'<'col-md-12'tr>>" +
            "<'row'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu:[
                [10,25,50,100,-1],
                [10,25,50,100,"All"]
            ]
        } );

        table.buttons().container()
            .appendTo( '#kelas_wrapper .col-md-5:eq(0)' );
    } );
    </script>
@endpush
