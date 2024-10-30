<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StudentPhone;

class StudentPhonesController extends Controller
{
    public function destroy($id){
        $studentphone = StudentPhone::find($id);
        $student = $studentphone->student;

        // check if the profile is locked
        if($student->isProfileLocked()){
            return redirect()->back()->with("error",'Profile Locked. PLease contact to admin');
        }    
        $studentphone->delete();

        // Recalculate profile Score
        if($student){
            $student->calculateProfileScore();
        }


        session()->flash("info","Delete");
        return redirect()->back();
    }
}
