@extends('admin.base')

@section('title')
    Data Barang
@endsection

@section('content')

    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", "Berhasil Menambah data!", "success");
        </script>
    @endif

    <section class="m-2">

        <div class="table-container">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-3">Laporan</h5>
                <form id="formTanggal">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-calendar me-2' style="font-size: 1.4rem"></i>
                        <div class="me-2">
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control me-2" name="start" style="background-color: white"
                                       readonly value="{{ request('start') }}" required>
                                <div class="input-group-addon">to</div>
                                <input type="text" class="form-control ms-2" name="end" style="background-color: white"
                                       readonly value="{{ request('end') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mx-2">Cari</button>
                        <a class="btn btn-warning" id="cetak" target="_blank">Cetak</a>
                    </div>
                </form>

            </div>

            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Harga</th>
                </tr>
                </thead>
                @forelse($data as $key => $d)

                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td>{{$d->user->name}}</td>
                        <td>{{date('d F Y', strtotime($d->updated_at))}}</td>
                        <td>Rp. {{number_format($d->total_harga,0)}}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">Tidak ada data</td>
                    </tr>
                @endforelse

            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>

        </div>

    </section>

@endsection

@section('script')
    <script>
        $('.input-daterange input').each(function () {
            $(this).datepicker({
                format: "dd-mm-yyyy"
            });
        });
        $(document).on('click', '#cetak', function () {
            $(this).attr('href', '/cetaklaporanpendapatan?' + $('#formTanggal').serialize());
        })
    </script>

@endsection
