<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class SiswaController extends Controller
{

    // nampil
    public function getsiswa()
    {
        $dt_siswa = Siswa::get();
        return response()->json($dt_siswa);
    }

    // create
    public function createsiswa(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'nama_siswa' => 'required',
            'tanggal_lahir' => 'required',
            'gender' => 'required',
            'alamat' => 'required',
        ]);



        if ($validator->fails()) {
            return Response()->json($validator->errors()->toJson());
        

        }
        // if ($req->hasFile('image')) {
        //     $image = $req->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $imageName);
        //     return response()->json($image);
        // }

        $imageName = $req->file('gambar');
        $imageName->storeAs('public/images' , $imageName->hashName());

        $create = Siswa::create([
            'nama_siswa' => $req->get('nama_siswa'),
            'tanggal_lahir' => $req->get('tanggal_lahir'),
            'gender' => $req->get('gender'),
            'gambar' => $imageName->hashName(),
            'alamat' => $req->get('alamat')
        ]);
        if ($create) {
            return Response()->json(['status' => true, 'message' => 'Sukses Menambah Siswa']);
        } else {
            return Response()->json(['status' => false, 'message' => 'Gagal Menambah Siswa']);
        }
    }

    // update
    public function updatesiswa(Request $req, $id){

        $validator =  Validator::make($req->all(),[
            'nama_siswa'=>'required',
            'tanggal_lahir'=>'required',
            'gender'=>'required',
            'alamat'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors()->toJson());
        }
        $imagename = time() . '.' . $req->foto->extension();
        $req->foto-> move(public_path('images'),$imagename); 
        $ubah= siswa::where('id',$id)->update(
            [
                'nama_siswa' => $req->input('nama_siswa'),
                'tanggal_lahir' => $req->input('tanggal_lahir'),
                'gender' => $req->input('gender'),
                'gambar' => $imagename,
                'alamat' => $req->input('alamat'),
            ]);

            if($ubah){
                return Response()->json(['status' => true , 'message' => 'sukses update siswa' ]);
            }else{
                return Response()->json(['status' => false , 'message' => 'Gagal update siswa' ]);

            }
    }

      // delet

      public function deletesiswa($id){

        $hapus = siswa::find($id) -> delete();
        

        if($hapus){
            return Response()->json(['status' => true , 'message' => 'sukses hapus siswa' ]);
        }else{
            return Response()->json(['status' => false , 'message' => 'Gagal hapus siswa' ]);
        }
    }


    // gambar
}
