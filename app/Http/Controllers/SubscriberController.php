<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Auth;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$subscribers = Subscriber::orderBy('id','desc')->get();
        return view('admin.subscriber.subscribers',compact('subscribers'));
    }

    public function download()
    {

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=subscribers.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Subscribers Emails'));
        $result = Subscriber::all();
        foreach ($result as $row){
            fputcsv($output, $row->toArray());
        }
        fclose($output);
    }
}
