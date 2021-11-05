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
                <h5>Data User</h5>
                <button type="button ms-auto" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#tambahsiswa">Tambah Data</button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                    <th>
                        #
                    </th>

                    <th>
                        Nama Kapal
                    </th>

                    <th>
                        Kapasitas
                    </th>

                    <th>
                        Keterangan
                    </th>

                    <th>
                        Foto
                    </th>

                    <th>
                        Action
                    </th>

                </thead>

                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        Siginjai
                    </td>
                    <td>
                        200
                    </td>
                    <td>
                        Kapal Ferry
                    </td>
                    
                    <td>
                        <img src="https://i.ytimg.com/vi/Ljq1muZoudA/sddefault.jpg"
                            style="width: 75px; height: 100px; object-fit: cover" />
                    </td>
                    <td style="width: 150px">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#tambahsiswa">Ubah</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
                    </td>
                </tr>

            </table>

        </div>


        <div>


            <!-- Modal Tambah-->
            <div class="modal fade" id="tambahsiswa" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kapal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Kapal</label>
                                    <input type="text" required class="form-control" id="nama">
                                </div>

                                <div class="mb-3">
                                    <label for="kapasitas" class="form-label">Kapasitas</label>
                                    <input type="number" required class="form-control" id="kapasitas">
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="alamat" rows="3"></textarea>
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input class="form-control" type="file" id="foto">
                                </div>


                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function() {

        })

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
