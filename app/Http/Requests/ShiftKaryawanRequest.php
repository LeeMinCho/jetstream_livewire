<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftKaryawanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "v_shift_jadwal_code" => "required",
            "v_shift_jadwal_desc" => "required",
            "lama_jam_kerja" => "required",
            "keterangan" => "required",
            "jam_masuk" => "required",
            "jam_keluar" => "required",
            "is_lewathari" => "required",
            "is_libur" => "required",
            "color" => "required",
        ];
    }
}
