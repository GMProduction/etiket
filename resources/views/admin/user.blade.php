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
                {{-- <button type="button ms-auto" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#tambahsiswa">Tambah Data</button> --}}
                <div>
                    <button type="button" class="btn btn-primary btn-sm" id="addData">Tambah Data
                    </button>
                </div>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <th>#</th>
                <th>Avatar</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Hp</th>
                <th>Role</th>
                <th>Action</th>
                </thead>
                @forelse($data as $key => $d)

                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td width="100">
                            <img src="{{$d->avatar}}" onerror="this.src='{{asset('/images/nouser.png')}}'; this.error=null"
                                 style=" height: 100px; object-fit: cover"/>
                        </td>
                        <td>{{$d->name}}</td>
                        <td>{{$d->alamat}}</td>
                        <td>{{$d->no_hp}}</td>
                        <td>{{$d->role}}</td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" data-username="{{$d->username}}" data-no_hp="{{$d->no_hp}}" data-alamat="{{$d->alamat}}" data-nama="{{$d->name}}"
                                    data-roles="{{$d->role}}" data-id="{{$d->id}}" id="editData">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('{{$d->id}}', '{{$d->nama}}') ">Hapus</button>
                            @if($d->roles == 'mitra')
                                <button type="button" class="btn btn-warning btn-sm d-block mt-2" style="color: white" data-nama="{{$d->nama}}" data-id="{{$d->id}}" id="dataKos">Data Kos</button>
                            @endif
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data user</td>
                    </tr>
                @endforelse

            </table>
            <div class="d-flex justify-content-end">
                {{$data->links()}}
            </div>
        </div>


        <div>


            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" onsubmit="return save()">
                                @csrf
                                <input type="hidden" name="id" id="id">

                                <div class="mb-3">
                                    <label for="roles" class="form-label">Role</label>
                                    <div class="d-flex">
                                        <select class="form-select" aria-label="Default select example" id="roles" name="role">
                                            <option selected disabled value="">Pilih Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="agen">Agen</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama" name="name">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" rows="3" name="alamat"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="nphp" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="nphp" name="no_hp">
                                </div>


                                <hr>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username" name="username">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" required class="form-control" id="password" name="password">
                                </div>

                                <div class="mb-3">
                                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" required class="form-control" id="password-confirmation" name="password_confirmation">
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <div class="d-flex">
                                        <select class="form-select" aria-label="Default select example" name="idguru">
                                            <option selected>Mata Pelajaran</option>
                                            <option value="1">Erfin</option>
                                            <option value="2">Joko A</option>
                                            <option value="3">Joko B</option>
                                        </select>
                                        <a class="btn btn-primary">+</a>
                                    </div>
                                </div> --}}

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
        $(document).ready(function () {

        })

        $(document).on('click', '#addData, #editData', function () {
            $('#modal #id').val($(this).data('id'));
            $('#modal #nama').val($(this).data('nama'));
            $('#modal #roles').val($(this).data('roles'));
            $('#modal #alamat').val($(this).data('alamat'));
            $('#modal #nphp').val($(this).data('no_hp'));
            $('#modal #username').val($(this).data('username'));
            $('#modal #password').val('');
            $('#modal #password-confirmation').val('');
            if ($(this).data('id')) {
                $('#modal #password').val('**********');
                $('#modal #password-confirmation').val('**********');
            }
            $('#modal').modal('show');
        })

        function save() {
            saveData('Simpan Data', 'form', window.location.pathname + '/register')
            return false;
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
