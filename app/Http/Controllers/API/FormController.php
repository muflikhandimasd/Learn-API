<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function getAll(Request $request)
    {
        $students = Student::all();
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully fetched all students',
            'students' => $students
        ], 200);
    }

    public function show(Request $request)
    {
        $perPage = $request->get('per_page');

        $students = Student::paginate($perPage);
        foreach ($students as $index => $value) {
            $data['id'] = $value->id;
            $data['nama'] = $value->nama;
            $data['alamat'] = $value->alamat;
            $data['no_telp'] = $value->no_telp;
            $datas[] = $data;
        }
        $dataStudent['data'] = $datas;
        $dataStudent['limit'] = $students->perPage();
        $dataStudent['total_pages'] = $students->lastPage();
        $dataStudent['current_page'] = $students->currentPage();



        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully fetched all students',
            'students' => $dataStudent
        ], 200);
    }


    public function getDetail($id)
    {
        $student = Student::find($id);
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully fetched student',
            'student' => $student
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|integer |digits_between:10,15',
        ]);
        // $student = Student::create($request->all());

        $student = new Student;
        $student->nama = $request->nama;
        $student->alamat = $request->alamat;
        $student->no_telp = $request->no_telp;
        $student->save();
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully created',
            'student' => $student
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|integer |digits_between:10,15',
        ]);
        // $student->update($request->all());
        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully updated',
            'student' => $student
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully deleted'
        ], 200);
    }
}
