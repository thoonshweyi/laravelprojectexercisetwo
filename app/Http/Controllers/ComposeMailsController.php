<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ComposeMailJob;


class ComposeMailsController extends Controller
{
    public function mail(Request $request){
        // dd($request["cmpemail"]);        // "admin@gmail.com"
        // dd($request["cmpsubject"]);      // "very important" // app\Http\Controllers\StudentsController.php:131
        // dd($request["cmpcontent"]);      // "hello" // app\Http\Controllers\StudentsController.php:132
        
        // Method 1 (to MailBox)
        // $to = $request["cmpemail"];
        // $subject = $request["cmpsubject"];
        // $content = $request["cmpcontent"];
        // Mail::to($to)->send(new MailBox($subject,$content));
        // Mail::to($to)->cc("admin@dlt.com")->bcc("info@dlt.com")->send(new MailBox($subject,$content));

        // =>Usng Jog Method 1 (to MailBox)
        // dispatch(new MailBoxJob($to,$subject,$content));
        // MailBoxJob::dispatch($to,$subject,$content);

        // =>Method 2 (to StudentMailBox)
        // $data["to"] = $request["cmpemail"];
        // $data["subject"] = $request["cmpsubject"];
        // $data["content"] = $request["cmpcontent"];

        $data = [
            "to" => $request["cmpemail"],
            "subject" => $request["cmpsubject"],
            "content" => $request["cmpcontent"]
        ];
        
        // Mail::to($data["to"])->send(new StudentMailBox($data));
        dispatch(new ComposeMailJob($data));

        return redirect()->back();
    }
}
