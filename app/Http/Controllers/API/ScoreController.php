<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\Student;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function create(Request $request)
    {
        // dd($request->all());
        $student = new Student;
        $student->nama = $request->nama;
        $student->alamat = $request->alamat;
        $student->no_telp = $request->no_telp;
        $student->save();



        foreach ($request->list_pelajaran as $index => $value) {
            $score = array(
                'student_id' => $student->id,
                'mata_pelajaran' => $value['mata_pelajaran'],
                'nilai' => $value['nilai']
            );
            Score::create($score);
        }
        $scores = Score::where('student_id', $student->id)->get();

        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully created',
            'scores' => $scores
        ], 200);
    }

    public function getStudent($id)
    {
        // $student = Student::find($id);
        // $scores = Score::where('student_id', $student->id)->get();
        // return response()->json([
        //     'api_status' => 200,
        //     'message' => 'Successfully created',
        //     'student' => $student,
        //     'scores' => $scores
        // ], 200);

        $student = Student::with('score')->where('id', $id)->first();
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully get student',
            'student' => $student
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);
        Score::where('student_id', $student->id)->delete();
        foreach ($request->list_pelajaran as $index => $value) {
            $score = array(
                'student_id' => $student->id,
                'mata_pelajaran' => $value['mata_pelajaran'],
                'nilai' => $value['nilai']
            );
            Score::create($score);
        }
        $scores = Score::where('student_id', $student->id)->get();
        return response()->json([
            'api_status' => 200,
            'message' => 'Successfully updated',
            'student' => $student,
            'scores' => $scores
        ], 200);
    }
}
