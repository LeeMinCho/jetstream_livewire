<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftKaryawanRequest;
use App\Models\ShiftKaryawan;
use Illuminate\Http\Request;
use PDF;

class ShiftKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("shift_karyawan");
    }

    public function datatable(Request $request)
    {
        $columns = [null, 'v_shift_jadwal_code', 'v_shift_jadwal_desc', 'jam_masuk', 'jam_keluar', 'lama_jam_kerja', 'keterangan', 'is_lewathari', 'is_libur', 'color'];

        $totalData = ShiftKaryawan::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $shift_karyawan = ShiftKaryawan::offset($start)
                ->limit($limit)
                ->when($order, function ($query) use (&$order, &$dir) {
                    return $query->orderBy($order, $dir);
                }, function ($query) {
                    return $query->orderBy("n_shif_jadwal_karyawan_id", "desc");
                })
                ->get();
        } else {
            $search = strtolower($request->input('search.value'));

            $shift_karyawan =  ShiftKaryawan::where('v_shift_jadwal_code', 'ILIKE', "%{$search}%")
                ->orWhere('v_shift_jadwal_desc', 'ILIKE', "%{$search}%")
                ->orWhere('jam_masuk', 'ILIKE', "%{$search}%")
                ->orWhere('jam_keluar', 'ILIKE', "%{$search}%")
                ->orWhere('lama_jam_kerja', 'ILIKE', "%{$search}%")
                ->orWhere('keterangan', 'ILIKE', "%{$search}%")
                ->orWhere('is_lewathari', 'ILIKE', "%{$search}%")
                ->orWhere('is_libur', 'ILIKE', "%{$search}%")
                ->orWhere('color', 'ILIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->when($order, function ($query) use (&$order, &$dir) {
                    return $query->orderBy($order, $dir);
                }, function ($query) {
                    return $query->orderBy("n_shif_jadwal_karyawan_id", "desc");
                })
                ->get();

            $totalFiltered = ShiftKaryawan::where('v_shift_jadwal_code', 'ILIKE', "%{$search}%")
                ->orWhere('v_shift_jadwal_desc', 'ILIKE', "%{$search}%")
                ->orWhere('jam_masuk', 'ILIKE', "%{$search}%")
                ->orWhere('jam_keluar', 'ILIKE', "%{$search}%")
                ->orWhere('lama_jam_kerja', 'ILIKE', "%{$search}%")
                ->orWhere('keterangan', 'ILIKE', "%{$search}%")
                ->orWhere('is_lewathari', 'ILIKE', "%{$search}%")
                ->orWhere('is_libur', 'ILIKE', "%{$search}%")
                ->orWhere('color', 'ILIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($shift_karyawan)) {
            $no = $start + 1;
            foreach ($shift_karyawan as $sk) {
                $row = array();
                $row[] = $no;
                $row[] = $sk->v_shift_jadwal_code;
                $row[] = $sk->v_shift_jadwal_desc;
                $row[] = $sk->jam_masuk;
                $row[] = $sk->jam_keluar;
                $row[] = $sk->lama_jam_kerja;
                $row[] = $sk->keterangan;
                $row[] = $sk->is_lewathari;
                $row[] = $sk->is_libur;
                $row[] = $sk->color;
                $json_data = json_encode($sk);
                $row[] = "<button class=\"btn bg-pink waves-effect\" onclick=\"edit_shift(" . htmlentities($json_data) . ")\">
                    <i class=\"material-icons\">mode_edit</i>
                </button>";
                $no++;

                $data[] = $row;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function cetakPdf()
    {
        $data["shift_karyawan"] = ShiftKaryawan::all();
        $pdf = PDF::loadView("cetak_shift_karyawan", $data);
        return $pdf->download("Shift_karyawan_" . time() . ".pdf");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftKaryawanRequest $request)
    {
        $data = $request->all();
        ShiftKaryawan::insert($data);
        return response(["message" => "Berhasil menyimpan data!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftKaryawanRequest $request, $id)
    {
        $data = $request->all();
        $shift_karyawan = ShiftKaryawan::findOrFail($id);
        $shift_karyawan->update($data);
        return response(["message" => "Berhasil Mengubah Data"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
