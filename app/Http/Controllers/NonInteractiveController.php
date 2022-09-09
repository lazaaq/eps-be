<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use DataTables;
use App\NonInteractive;
use App\Package;
use App\QuizType;
use App\Transaction;
use File;
use DB;
use Auth;
use Carbon\Carbon;

class NonInteractiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use ResponseAPI;

    public function getData($id){
        $data = NonInteractive::with('package.quizType.quizCategory')->where('package_id',$id)->get();
        return datatables()->of($data)->addColumn('action', function($row){
            $btn = '<a href="'.route('noninteractive.edit',$row->id).'" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
            $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
            return $btn;
        })
        ->addColumn('type', function($row){
            return comCd($row->type);
        })
        ->rawColumns(['action'])
        ->make(true);

    }

    public function index()
    {
         return view('non-interactive.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quiztype = QuizType::all()->sortBy('name');
        return view('non-interactive.create', compact('quiztype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        $this->validate(request(),
        [
            'quiz_type' => 'required',
            'price' => 'required',
            'type.*' => 'required',
            'name.*' => 'required',
            'description.*' => 'required',
            // 'urlmeet.*' => 'required',
        ]);

        DB::beginTransaction();
        $data = new Package;
        $data->quiz_type_id = $request->quiz_type;
        $data->price = $request->price;
        $data->save();

        for ($i=0; $i <count($request->typefile) ; $i++) {
            $noninteractive             = new NonInteractive;
            $noninteractive->package_id = $data->id;
            $noninteractive->type       = $request->typefile[$i];
            $noninteractive->name       = $request->name[$i];
            $noninteractive->description= $request->description[$i];
            if (filter_var($request->fileurl[$i], FILTER_VALIDATE_URL)) {
                $noninteractive->file_url   = $request->fileurl[$i];
            } else {
                $file = $request->file("fileurl");
                return $request->file("fileurl")->getClientOriginalExtension();
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = \Str::uuid() . '.' . $extension;
                Storage::put('public/file/non-interactive/' . $filename, File::get($file));
                $noninteractive->file_url   = $filename;
            }
            $noninteractive->save();
        }

        DB::commit();
        return redirect()->route('noninteractive.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $data = Package::with('nonInteractive')->find($id);
        return view('non-interactive.edit', compact('data','quiztype'));

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
        ]);

        DB::beginTransaction();
        $data = Package::find($id);
        $data->quiz_type_id = $request->quiz_type;
        $data->price = $request->price;
        $data->save();
        DB::commit();
        return redirect()->route('noninteractive.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $data = Package::find($id);
        // $data->nonInteractive()->delete();
        // $data->delete();
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
                    $data = NonInteractive::where('package_id', $id)->get();
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
