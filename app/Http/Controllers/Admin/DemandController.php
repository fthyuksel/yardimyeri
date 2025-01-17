<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpData;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    public function index(Request $request){

        $data=$request->has('status')
        ? HelpData::orderBy('created_at', 'DESC')->with('helper')->where('help_status',$request->status)->paginate(200)
        : HelpData::orderBy('created_at', 'DESC')->with('helper')->paginate(200);
        
        $status=$request->status;

        return view('admin.demands', compact('data','status'));
    }

    public function show($id){
        $data=HelpData::find($id);

        return view('admin.demand-show',compact('data'));
    }

    public function update(Request $request, $id){
        $data=HelpData::find($id);

        $data->name = $request->name;
        $data->tel = $request->tel;
        $data->ihtiyac_turu_detayi = $request->ihtiyac_turu_detayi;
        $data->kac_kisilik = $request->kac_kisilik;
        $data->help_status = $request->help_status;

        $status=$data->save();


        return $status
        ? back()->with('success','Talep Güncellendi')
        : back()->with('error','Talep Güncellenemedi');
    }
}
