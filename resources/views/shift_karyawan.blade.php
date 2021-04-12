@extends('layouts.template')

@section('title')
Shift Karyawan
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h4>Shift Karyawan</h4>
                    </div>
                    <div class="body">
                        <table class="table table-bordered table-striped" id="table_shift_karyawan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Durasi</th>
                                    <th>Keterangan</th>
                                    <th>Lewat Hari</th>
                                    <th>Libur</th>
                                    <th>Warna</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-shift-karyawan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-red">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="n_shif_jadwal_karyawan_id">
                <!--------- form ------- -->
                <div class="row clearfix">
                    <div class="col-sm-6">
                        <b>Kode Shift</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="v_shift_jadwal_code"
                                    id="v_shift_jadwal_code">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <b>Nama Shift</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="v_shift_jadwal_desc"
                                    id="v_shift_jadwal_desc">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <b>Lewat Hari</b>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control selectpicker show-tick" name="is_lewathari"
                                    id="is_lewathari" title="- Pilih -">
                                    <option value='0'>Tidak</option>
                                    <option value='1'>Ya</option>
                                </select>
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <b>Jam Masuk</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="jam_masuk" id="jam_masuk">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <b>Jam Keluar</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="jam_keluar" id="jam_keluar">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <b>Durasi Kerja</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="lama_jam_kerja" id="lama_jam_kerja">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <b>Keterangan</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control" name="keterangan" id="keterangan">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <b>Libur</b>
                        <div class="form-group">
                            <div class="form-line">
                                <select class="form-control selectpicker show-tick" name="is_libur" id="is_libur"
                                    title="- Pilih -">
                                    <option value='0'>Tidak</option>
                                    <option value='1'>Ya</option>
                                </select>
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-sm-6">
                        <b>Warna</b>
                        <div class="form-group">
                            <div class="form-line">
                                <input type="color" name="color" id="color" class="form-control">
                            </div>
                            <div class="error"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-red waves-effect" id="btn_shift_karyawan">SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    datatable();

    function datatable() {
        $('#table_shift_karyawan').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('shift_karyawan/datatable') }}",
                "dataType": "json",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [{ 
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }],

            dom: 'Bfrtip',
            buttons: [{
                text: '<i class="material-icons">add_circle</i><span>Tambah Shift</span>',
                className: 'btn btn-primary waves-effect',
                action: function () {
                    create_shift();
                }
            }, {
                text: '<i class="material-icons">print</i><span>Cetak PDF</span>',
                className: 'btn btn-primary waves-effect',
                action: function () {
                    // alert("Sombong");
                    var form = document.createElement("form");
                    document.body.appendChild(form);
                    form.setAttribute("id", "cetak_label");
                    form.setAttribute("target", "_blank");
                    form.method = "GET";
                    form.action = "{{ url("shift_karyawan/cetak_pdf") }}";
                    /* var element = document.createElement("INPUT");
                    element.name = "n_barang_id[]";
                    element.value = n_barang_id[index];
                    element.type = "hidden";
                    form.appendChild(element); */
                    form.submit();
                    form.remove();
                }
            }],
            "destroy": true,
        });
    }

    function create_shift() {
        $("#v_shift_jadwal_code").val("");
        $("#v_shift_jadwal_desc").val("");
        $("#jam_masuk").val("");
        $("#jam_keluar").val("");
        $("#lama_jam_kerja").val("");
        $("#keterangan").val("");
        $(".selectpicker").selectpicker("deselectAll");
        $(".error").html("");
        $("#btn_shift_karyawan").attr("onclick", "save_shift()");
        $("#modal-shift-karyawan").find(".modal-title").html("Tambah Shift Karyawan");
        $("#modal-shift-karyawan").modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    function save_shift() {
        $.ajax({
            url: "{{ url("shift_karyawan") }}",
            type: "POST",
            data:{
                v_shift_jadwal_code: $("#v_shift_jadwal_code").val(),
                v_shift_jadwal_desc: $("#v_shift_jadwal_desc").val(),
                is_lewathari: $("#is_lewathari").val(),
                jam_masuk: $("#jam_masuk").val(),
                jam_keluar: $("#jam_keluar").val(),
                lama_jam_kerja: $("#lama_jam_kerja").val(),
                keterangan: $("#keterangan").val(),
                is_libur: $("#is_libur").val(),
                color: $("#color").val(),
            },
            dataType: "JSON",
            error: function (xhr, data) {
                if (xhr.status == 422) {
                    var response = xhr.responseJSON.errors;
                    $("#v_shift_jadwal_code").parents(".form-group").find(".error").html((response["v_shift_jadwal_code"] ? response["v_shift_jadwal_code"][0] : ""));
                    $("#v_shift_jadwal_desc").parents(".form-group").find(".error").html((response["v_shift_jadwal_desc"] ? response["v_shift_jadwal_desc"][0] : ""));
                    $("#is_lewathari").parents(".form-group").find(".error").html((response["is_lewathari"] ? response["is_lewathari"][0] : ""));
                    $("#jam_masuk").parents(".form-group").find(".error").html((response["jam_masuk"] ? response["jam_masuk"][0] : ""));
                    $("#jam_keluar").parents(".form-group").find(".error").html((response["jam_keluar"] ? response["jam_keluar"][0] : ""));
                    $("#lama_jam_kerja").parents(".form-group").find(".error").html((response["lama_jam_kerja"] ? response["lama_jam_kerja"][0] : ""));
                    $("#keterangan").parents(".form-group").find(".error").html((response["keterangan"] ? response["keterangan"][0] : ""));
                    $("#is_libur").parents(".form-group").find(".error").html((response["is_libur"] ? response["is_libur"][0] : ""));
                    $("#color").parents(".form-group").find(".error").html((response["color"] ? response["color"][0] : ""));
                }
            },
            success: function(data) {
                $("#modal-shift-karyawan").modal("hide");
                swal({
                    title: "Berhasil!",
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false,
                    type: "success",
                });
                setTimeout(function() {
                    datatable();
                }, 2000);
            }
        });
    }

    function edit_shift(data) {
        $("#n_shif_jadwal_karyawan_id").val(data.n_shif_jadwal_karyawan_id);
        $("#v_shift_jadwal_code").val(data.v_shift_jadwal_code);
        $("#v_shift_jadwal_desc").val(data.v_shift_jadwal_desc);
        $("#jam_masuk").val(data.jam_masuk);
        $("#jam_keluar").val(data.jam_keluar);
        $("#lama_jam_kerja").val(data.lama_jam_kerja);
        $("#keterangan").val(data.keterangan);
        $("#is_libur").val(data.is_libur);
        $("#is_lewathari").val(data.is_lewathari);
        $(".selectpicker").selectpicker("refresh");
        $(".error").html("");
        $("#btn_shift_karyawan").attr("onclick", "update_shift()");
        $("#modal-shift-karyawan").find(".modal-title").html("Update Shift Karyawan");
        $("#modal-shift-karyawan").modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    function update_shift() {
        var n_shif_jadwal_karyawan_id = $("#n_shif_jadwal_karyawan_id").val();
        $.ajax({
            url: "{{ url("shift_karyawan") }}/" + n_shif_jadwal_karyawan_id,
            type: "PUT",
            data:{
                v_shift_jadwal_code: $("#v_shift_jadwal_code").val(),
                v_shift_jadwal_desc: $("#v_shift_jadwal_desc").val(),
                is_lewathari: $("#is_lewathari").val(),
                jam_masuk: $("#jam_masuk").val(),
                jam_keluar: $("#jam_keluar").val(),
                lama_jam_kerja: $("#lama_jam_kerja").val(),
                keterangan: $("#keterangan").val(),
                is_libur: $("#is_libur").val(),
                color: $("#color").val(),
            },
            dataType: "JSON",
            error: function (xhr, data) {
                if (xhr.status == 422) {
                    var response = xhr.responseJSON.errors;
                    $("#v_shift_jadwal_code").parents(".form-group").find(".error").html((response["v_shift_jadwal_code"] ? response["v_shift_jadwal_code"][0] : ""));
                    $("#v_shift_jadwal_desc").parents(".form-group").find(".error").html((response["v_shift_jadwal_desc"] ? response["v_shift_jadwal_desc"][0] : ""));
                    $("#is_lewathari").parents(".form-group").find(".error").html((response["is_lewathari"] ? response["is_lewathari"][0] : ""));
                    $("#jam_masuk").parents(".form-group").find(".error").html((response["jam_masuk"] ? response["jam_masuk"][0] : ""));
                    $("#jam_keluar").parents(".form-group").find(".error").html((response["jam_keluar"] ? response["jam_keluar"][0] : ""));
                    $("#lama_jam_kerja").parents(".form-group").find(".error").html((response["lama_jam_kerja"] ? response["lama_jam_kerja"][0] : ""));
                    $("#keterangan").parents(".form-group").find(".error").html((response["keterangan"] ? response["keterangan"][0] : ""));
                    $("#is_libur").parents(".form-group").find(".error").html((response["is_libur"] ? response["is_libur"][0] : ""));
                    $("#color").parents(".form-group").find(".error").html((response["color"] ? response["color"][0] : ""));
                }
            },
            success: function(data) {
                $("#modal-shift-karyawan").modal("hide");
                swal({
                    title: "Berhasil!",
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false,
                    type: "success",
                });
                setTimeout(function() {
                    datatable();
                }, 2000);
            }
        });
    }
</script>
@endpush