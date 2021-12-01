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
                <button type="button" class="btn btn-primary btn-sm" id="addData">Tambah Data</button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kapal</th>
                    <th>Kapasitas</th>
                    <th>Keterangan</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
                </thead>

                @forelse($data as $key => $d)
                    <tr>
                        <td>{{$data->firstItem() + $key}}</td>
                        <td>{{$d->nama}}</td>
                        <td>{{$d->kapasitas}}</td>
                        <td>{{$d->keterangan}}</td>
                        <td width="100">
                            <img src="{{$d->image}}" onerror="this.src='{{asset('/images/noimage.png')}}'; this.error=null"
                                 style=" height: 100px; object-fit: cover"/>
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" id="editData" data-image="{{$d->image}}" data-keterangan="{{$d->keterangan}}" data-kapasitas="{{$d->kapasitas}}"
                                    data-nama="{{$d->nama}}" data-id="{{$d->id}}">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus</button>
                            <button type="button" class="btn btn-info btn-sm" style="color: white" id="jadwalData" data-id="{{$d->id}}">Jadwal</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data user</td>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kapal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" onsubmit="return save()">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Kapal</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <div class="mb-3">
                                    <label for="kapasitas" class="form-label">Kapasitas</label>
                                    <input type="number" required class="form-control" id="kapasitas" name="kapasitas">
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" rows="3" name="keterangan"></textarea>
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="image" class="form-label">Foto</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalJadwal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kapal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formJadwal" onsubmit="return saveJawal()">
                                @csrf
                                <input type="hidden" class="txtJadwal" name="id" id="id">
                                <input type="hidden" name="id_kapal" id="id_kapal">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Hari</label>
                                            <select class="form-select txtJadwal" id="hari" name="hari">
                                                <option value="" selected disabled></option>
                                                <option value="0">Senin</option>
                                                <option value="1">Selasa</option>
                                                <option value="2">Rabu</option>
                                                <option value="3">Kamis</option>
                                                <option value="4">Jum'at</option>
                                                <option value="5">Sabtu</option>
                                                <option value="6">Minggu</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="kapasitas" class="form-label">Jam</label>
                                            <input type="time" name="jam" id="jam" class="form-control txtJadwal">
                                        </div>
                                        <div class="mt-3 mb-2">
                                            <label for="keterangan">Harga</label>
                                            <input type="number" name="harga" id="harga" class="form-control txtJadwal">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="keterangan">Pelabuhan Asal</label>
                                            <select id="asal" class="form-select txtJadwal" name="id_asal"></select>
                                        </div>

                                        <div class="mt-3 mb-2">
                                            <label for="keterangan">Pelabuhan Tujuan</label>
                                            <select id="tujuan" class="form-select txtJadwal" name="id_tujuan"></select>
                                        </div>
                                        <div class="mt-3 mb-2">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <a class="btn btn-success d-none" id="clearJadwal" onclick="clearJadwal()">Clear</a>
                                        </div>

                                    </div>
                                </div>
                            </form>
                            <div>
                                <table class="table">
                                    <tr>
                                        <th>#</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>Asal</th>
                                        <th>Tujuan</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tbody id="tbJadwal"></tbody>
                                </table>
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

        var id_kapal;
        $(document).ready(function () {

        })

        $(document).on('click', '#addData, #editData', function () {
            $('#modal #id').val($(this).data('id'));
            $('#modal #nama').val($(this).data('nama'));
            $('#modal #keterangan').val($(this).data('keterangan'));
            $('#modal #kapasitas').val($(this).data('kapasitas'));
            $('#modal').modal('show');
        })

        function saveJawal(){
            saveData('Simpan Data', 'formJadwal', window.location.pathname+'/jadwal/'+id_kapal, aftersave)
            return false;
        }

        function aftersave(){
            dataJadwal(id_kapal);
            clearJadwal()
        }

        $(document).on('click', '#jadwalData', function () {
            getSelect('asal', '{{route('pelabuhan-asal')}}', 'nama')
            id_kapal = $(this).data('id');
            dataJadwal($(this).data('id'))
            console.log(id_kapal)
            $('#modalJadwal #id').val('')
            $('#modalJadwal #id_kapal').val(id_kapal)
            $('#modalJadwal').modal('show')
        })



        $(document).on('change', '#asal', function () {
            console.log($(this).val())
            getSelect('tujuan', window.location.pathname+'/pelabuhan-tujuan?id='+$(this).val(), 'nama')
        })

        function hari() {

        }

        function dataJadwal(id) {
            console.log(new Date().toLocaleString());
            fetch(window.location.pathname+'/jadwal/'+id)
            .then(response => response.json())
            .then((data) => {
                $('#tbJadwal').empty();
                if (data.length > 0){
                    $.each(data, function (k, v) {
                        var hariData = ['Senin','Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu'];
                        var hari = hariData[v['hari']]
                        $('#tbJadwal').append('<tr>' +
                            '<td>'+parseInt(k+1)+'</td>' +
                            '<td>'+hari+'</td>' +
                            '<td>'+v.jam+'</td>' +
                            '<td>'+v.asal.nama+'</td>' +
                            '<td>'+v.tujuan.nama+'</td>' +
                            '<td>'+(v.harga).toLocaleString()+'</td>' +
                            '<td><a class="btn btn-sm btn-success mx-2" data-harga="'+v.harga+'" data-tujuan="'+v.id_tujuan+'" data-asal="'+v.id_asal+'" data-jam="'+v.jam+'" data-hari="'+v.hari+'" data-id="'+v.id+'" id="editJadwal"><i class=\'bx bx-edit-alt\'></i></a>' +
                            '<a class="btn btn-sm btn-danger" id="deleteJadwal" data-id="'+v.id+'" data-nama="'+hari+'" ><i class=\'bx bx-trash-alt\'></i></a></td>' +
                            '</td>')
                    })
                }else{
                    $('#tbJadwal').append('<tr><td class="text-center" colspan="7">Tidak ada jadwal</td></tr>');
                }
            })
        }

        function save() {
            saveData('Simpan Data', 'form', window.location.pathname)
            return false;
        }

        $(document).on('click', '#editJadwal', function () {
            $('#modalJadwal #id').val($(this).data('id'))
            $('#modalJadwal #hari').val($(this).data('hari'))
            $('#modalJadwal #jam').val($(this).data('jam'))
            $('#modalJadwal #harga').val($(this).data('harga'))
            $('#modalJadwal #asal').val($(this).data('asal'))
            getSelect('tujuan', window.location.pathname+'/pelabuhan-tujuan?id='+$(this).data('asal'), 'nama', $(this).data('tujuan'))

            $('#modalJadwal #clearJadwal').removeClass('d-none')
        })

       // $(document).on('click', '#clearJadwal', function () {
       //
       // })

        function clearJadwal() {
            $('.txtJadwal').val('')
            $('#tujuan').empty();
            $('#modalJadwal #clearJadwal').addClass('d-none')
        }

        $(document).on('click','#deleteJadwal', function () {
            deleteData($(this).data('nama'),window.location.pathname+'/jadwal/delete/'+$(this).data('id'), aftersave)
            return false;
        })

        function deleteJadwal(id, name) {

        }
    </script>

@endsection
