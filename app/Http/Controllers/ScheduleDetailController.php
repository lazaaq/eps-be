<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use App\Traits\ResponseAPI;
use DataTables;
use App\Schedule;
use App\Package;
use App\Transaction;
use App\ScheduleDetail;
use App\QuizType;
use Validator;
use File;
use DB;
use Auth;
use Carbon\Carbon;

class ScheduleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ResponseAPI;

    public function getData($id)
    {
        $data = ScheduleDetail::with('instructor')->where('package_id',$id)->get();
        return datatables()->of($data)->addColumn('action', function($row){
            $btn = '<a id="edit" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
            $btn = $btn.'  <a id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make  (true);
    }

    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $rules = [
            'instructor' => 'required',
            'datetime' => 'required',
            'duration' => 'required',
            // 'urlmeet' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else{
            $data                 = !empty($request->schedule_detail_id) ? ScheduleDetail::find($request->schedule_detail_id) : new ScheduleDetail;
            $data->package_id     = $request->package_id;
            $data->instructor_id  = $request->instructor;
            $data->kuota          = $request->kuota;
            $data->schedule       = Carbon::parse($request->datetime)->format('Y-m-d H:i');
            $data->duration       = $request->duration;
            $data->url_meet       = $request->urlmeet;
            $data->save();
            return response()->json(['success'=>'Data added successfully']);
        }
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
    public function update(Request $request, $id)
    {
        $rules = [
            'instructor_edit' => 'required',
            'datetime_edit' => 'required',
            'duration_edit' => 'required',
            'urlmeet_edit' => 'required',
            'kuota_edit' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        else{
            $data                 = ScheduleDetail::find($id);
            $data->instructor_id  = $request->instructor_edit;
            $data->kuota          = $request->kuota_edit;
            $data->schedule       = Carbon::parse($request->datetime_edit)->format('Y-m-d H:i');
            $data->duration       = $request->duration_edit;
            $data->url_meet       = $request->urlmeet_edit;
            $data->save();
            return response()->json(['success'=>'Data updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ScheduleDetail::find($id);
        $data->delete();
    }

    // START OF API

    function api_index($id){
        try {
            $check_userOnPack = Transaction::with('statusTransaction')->where('collager_id',Auth::user()->collager->id)->where('package_id',$id)->latest()->first();
            if ($check_userOnPack) {
                // CEK STATUS TRANSAKSI
                if ($check_userOnPack->status != 'STATUS_TRANS_2') {
                    return $this->success("Transaksi bermasalah pada status", $check_userOnPack);
                }
                // CEK VALID WAKTUNYA
                elseif ('start_date' >= Carbon::now() || 'expired_date' <= Carbon::now()) {
                    return $this->success("Transaksi bermasalah pada waktu", $check_userOnPack);
                }
                else {
                    $data = ScheduleDetail::with('instructor')->where('package_id', $id)->get();
                    return $this->success("Detail Schedule", $data);
                }
            } else {
                return $this->error('Beli dulu paketnya, baru bisa buka', 403);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }
}
