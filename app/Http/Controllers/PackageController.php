<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Arr;
use DataTables;
use App\Package;
use App\ScheduleDetail;
use App\QuizType;
use File;
use DB;
use App\Traits\ResponseAPI;
use Carbon\Carbon;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ResponseAPI;

    public function getData($type)
    {
        if ($type == 'schedule') {
            $data = Package::has('scheduleDetail')->with('quizType.quizCategory','scheduleDetail.instructor')->get();
            return datatables()->of($data)->addColumn('action', function($row){
                $btn = '<a href="'.route('package.edit',$row->id).'" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
                $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
                return $btn;
            })
            ->addColumn('package', function($row){
                return $row->quizType->quizCategory->root.' - '.$row->quizType->quizCategory->name.' - '.$row->quizType->name;
            })
            ->rawColumns(['action'])
            ->make(true);
        } elseif ($type == 'non-interactive') {
            $data = Package::has('nonInteractive')->with('nonInteractive','quizType.quizCategory')->get();
            return datatables()->of($data)->addColumn('action', function($row){
                $btn = '<a href="'.route('noninteractive.edit',$row->id).'" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
                $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
                return $btn;
            })
            ->addColumn('type', function($row){
                $type = '';
                foreach ($row->nonInteractive as $value) {
                    $type .= comCd($value->type).'<br>';
                }
                return $type;
            })
            ->rawColumns(['action','type'])
            ->make(true);
        }

    }
    public function index()
    {
        return view('schedule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quiztype = QuizType::all();
        return view('schedule.create', compact('quiztype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),
        [
            'quiz_type' => 'required',
            'quota' => 'required',
            'price' => 'required',
            'instructor.*' => 'required',
            'datetime.*' => 'required',
            'duration.*' => 'required',
            // 'urlmeet.*' => 'required',
        ]);

        DB::beginTransaction();
        $data = new Package;
        $data->quiz_type_id = $request->quiz_type;
        $data->quota = $request->quota;
        $data->price = $request->price;
        $data->save();

        $array_container = [];
        for ($i=0; $i < count($request->datetime); $i++) {
            $detail                 = new ScheduleDetail;
            $detail->package_id     = $data->id;
            $detail->instructor_id  = $request->instructor[$i];
            $detail->schedule       = Carbon::parse($request->datetime[$i])->format('Y-m-d H:i');
            $detail->duration       = $request->duration[$i];
            $detail->url_meet       = $request->urlmeet[$i];
            $detail->save();
        }

        DB::commit();
        return redirect()->route('package.index');
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
        $quiztype = QuizType::all()->sortBy('name');
        $data = Package::find($id);
        return view('schedule.edit', compact('quiztype','data'));
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
        $this->validate(request(),
        [
            'quiz_type' => 'required',
            'price' => 'required',
            'quota' => 'required'
        ]);

        DB::beginTransaction();
        $data = Package::find($id);
        $data->quiz_type_id = $request->quiz_type;
        $data->price = $request->price;
        $data->quota = $request->quota;
        $data->save();
        DB::commit();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Package::find($id);
        $data->scheduleDetail()->delete();
        $data->nonInteractive()->delete();
        $data->delete();
    }


    // START OF API

    function api_index($id){
        // $data = QuizType::with(['package.nonInteractive' => function($query) {
        //     $query->select(['id','type','name','description']);
        // }])
        // ->with(['package.scheduleDetail' => function($query) {
        //     $query->select(['id','instructor_id','schedule','duration']);
        // }])
        // ->find($id);

        $data = QuizType::find($id);
        $data->packageList = Package::where('quiz_type_id',$id)->with('scheduleDetail.instructor','nonInteractive')->get();
        return $this->success("List Package", $data);
    }

}
