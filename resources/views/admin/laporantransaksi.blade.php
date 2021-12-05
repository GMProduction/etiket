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
                    <div class="d-flex align-items-end">
                        <div >
                            {{-- <label for="kategori" class="form-label">Status Sewa</label>
                            <div class="d-flex">
                                <select class="form-select" aria-label="Default select example" name="idguru">
                                    <option selected>Semua</option>
                                    <option value="1">Menunggu Konfirmasi</option>
                                    <option value="1">Menunggu Jadwal</option>
                                    <option value="2">Di Pakai</option>
                                    <option value="3">Di Kembalikan</option>
                                </select>
                            </div> --}}
                        </div>

                        <div class="me-2 ms-2">
                            <label for="kategori" class="form-label">Periode</label>
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control me-2" name="start" style="background-color: white; line-height: 2.0;"
                                    readonly value="{{ request('start') }}" required>
                                <div class="input-group-addon">to</div>
                                <input type="text" class="form-control ms-2" name="end" style="background-color: white; line-height: 2.0;"
                                    readonly value="{{ request('end') }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mx-2">Cari</button>
                        <a class="btn btn-warning" id="cetak" target="_blank" href="/cetaklaporanpendapatan/{id}">Cetak</a>
                    </div>
                </form>

            </div>

            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Kapal</th>
                        <th>Tanggal</th>
                        <th>Tujuan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->jadwal->kapal->nama}}</td>
                        <td>{{date('l, d F Y', strtotime($d->tanggal))}} Jam {{date('H:i', strtotime($d->jadwal->jam))}}</td>
                        <td>{{$d->jadwal->asal->nama}} - {{$d->jadwal->tujuan->nama}}</td>
                        <td>{{$d->status == 1 ? 'Menunggu Checkin' : 'Sudah Checkin'}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="6">Tidak ada data</td>
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
        $('.input-daterange input').each(function() {
            $(this).datepicker({
                format: "dd-mm-yyyy"
            });
        });
        $(document).on('click', '#cetak', function() {
            $(this).attr('href', '/cetaklaporantransaksi?' + $('#formTanggal').serialize());
        })
    </script>

@endsection
