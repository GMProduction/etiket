@extends('admin.base')

@section('title')
    Data Siswa
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
                <h5>Data Transaksi</h5>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Status Sewa</label>
                    {{-- <div class="d-flex">
                        <select class="form-select" aria-label="Default select example" name="idguru">
                            <option selected>Semua</option>
                            <option value="1">Menunggu Konfirmasi</option>
                            <option value="1">Menunggu Jadwal</option>
                            <option value="2">Di Pakai</option>
                            <option value="3">Di Kembalikan</option>
                        </select>
                    </div> --}}
                </div>

            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Kapal</th>
                    <th>Tanggal</th>
                    <th>Status Pembayaran</th>
                    <th>Action</th>
                </tr>
                </thead>
                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td>{{$d->user->name}}</td>
                        <td>{{$d->pesanan[0]->jadwal->kapal->nama}}</td>
                        <td>{{$d->pesanan[0]->tanggal}}</td>
                        <td>{{$d->status == 0 ? 'Menunggu' : ($d->status == 1 ? 'Diterima' : 'Ditolak') }}</td>
                        <td style="width: 150px">
                            <a class="btn btn-success btn-sm" data-id="{{$d->id}}"
                               id="detailData">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data user</td>
                    </tr>
                @endforelse

            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>

        </div>


        <div>

            <!-- Detail-->
            <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detail1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detail1">Detail Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Nama Pelanggan</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="nPelanggan"></span></td>
                                        </tr>
                                        <tr class="mb-3">
                                            <th>No. Hp</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="hpPelanggan"></span></td>
                                        </tr>

                                        <tr class="mb-3">
                                            <th>Alamat</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="alPelanggan"></span></td>
                                        </tr>

                                    </table>
                                </div>

                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Nama Kapal</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="nKapal"></span></td>
                                        </tr>

                                        <tr>
                                            <th>Kapasitas</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="kKapal">200</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Keterangan</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="ketKapal"></span></td>
                                        </tr>
                                        <tr class="mb-3">
                                            <th>Rute</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="rute"></span></td>
                                        </tr>
                                    </table>

                                </div>

                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Tanggal Keberangkatan</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="tBerangkat"></span></td>
                                        </tr>

                                        <tr class="mb-3">
                                            <th>Total Biaya</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="tBiaya"></span></td>
                                        </tr>

                                    </table>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Kode Tiket</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbPemesan"></tbody>
                                    </table>
                                </div>

                                <div class="col-6">
                                    <table>
                                        <tr>
                                            <th>Bukti Pembayaran</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td>
                                                <span class="ms-3 mb-1"><a id="imgPay" target="_blank"
                                                                           style="cursor: pointer; display: inline_block"
                                                                           href=""><img
                                                            class="mb-1"
                                                            src=""
                                                            width="50px"/></a></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Action</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td>
                                                <div id="btnKonfirm">
                                                    <span class="ms-3"><a
                                                            class="btn btn-primary btn-sm" onclick="konfirmasi(1)">Terima</a></span>
                                                    <span class="ms-1"><a
                                                            class="btn btn-danger btn-sm" onclick="konfirmasi(2)">Tolak</a></span>
                                                </div>
                                                <div id="labelStatus">
                                                    <span>-</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status Bayar</th>
                                            <td><span class="ms-1"> :</span></td>
                                            <td><span class="ms-3" id="txtStatus"> </span></td>
                                        </tr>

                                        <div class="mb-4"></div>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>

    </section>

@endsection

@section('script')
    <script>
        var idPayment;
        $(document).ready(function () {

        })

        $(document).on('click', '#detailData', function () {
            $('#detail').modal('show');
            idPayment = $(this).data('id');
            dataDetail(idPayment);
        })

        function dataDetail(id) {
            fetch(window.location.pathname + '/' + id)
                .then(response => response.json())
                .then((data) => {
                    console.log(data);
                    $('#detail #nPelanggan').html(data.user.name);
                    $('#detail #alPelanggan').html(data.user.alamat);
                    $('#detail #hpPelanggan').html(data.user.no_hp);
                    $('#detail #nKapal').html(data.pesanan[0].jadwal.kapal.nama);
                    $('#detail #kKapal').html(data.pesanan[0].jadwal.kapal.kapasitas);
                    $('#detail #ketKapal').html(data.pesanan[0].jadwal.kapal.keterangan);
                    $('#detail #tBerangkat').html((data.pesanan[0].tanggal).toLocaleString());
                    $('#detail #rute').html(data.pesanan[0].jadwal.asal.nama + ' - ' + data.pesanan[0].jadwal.tujuan.nama);
                    $('#detail #tBiaya').html('Rp. ' + (data.total_harga).toLocaleString());
                    $('#detail #imgPay').attr('href', data.bukti_transfer);
                    $('#detail #imgPay img').attr('src', data.bukti_transfer);
                    var status = data.status;

                    $('#detail #btnKonfirm').addClass('d-none');
                    $('#detail #labelStatus').removeClass('d-none');

                    if (status === 0) {
                        $('#detail #txtStatus').html('Menunggu Pembayaran');
                        if (data.bukti_transfer) {
                            $('#detail #txtStatus').html('Menunggu Konfirmasi');
                            $('#detail #btnKonfirm').removeClass('d-none');
                            $('#detail #labelStatus').addClass('d-none');
                        }
                    } else if (status === 1) {
                        $('#detail #txtStatus').html('Pembayaran Diterima');
                    } else {
                        $('#detail #txtStatus').html('Pembayaran Ditolak');
                    }
                    $('#tbPemesan').empty();
                    $.each(data.pesanan, function (k, v) {
                        $('#tbPemesan').append('<tr>' +
                            '<td>' + parseInt(k + 1) + '</td>' +
                            '<td>' + v.nama + '</td>' +
                            '<td>' + (v.kode_tiket ?? '-') + '</td>' +
                            '</tr>')
                    })
                    console.log(data)
                })
        }

        function konfirmasi(a) {
            var dataForm = {
                status: a,
                '_token': '{{csrf_token()}}'
            };
            var title = 'Tolak'
            if (a === 1) {
                title = 'Terima'
            }

            saveDataObject(title + ' Pembayaran', dataForm, '/transaksi/' + idPayment, afterKonfirmasi)
            return false;
        }

        function afterKonfirmasi() {
            dataDetail(idPayment);

        }

        function hapus(id, name) {
            swal({
                title: "Menghapus data?",
                text: "Apa kamu yakin, ingin menghapus data ?!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil Menghapus data!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
