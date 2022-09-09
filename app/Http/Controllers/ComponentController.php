<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Traits\ResponseAPI;
use App\Component;
use Auth;
use DB;

class ComponentController extends Controller
{
    use ResponseAPI;

    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                    'group' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->all(), 200);
            } else {
                $data = Component::where('code_group',$request->group)->get();
                return $this->success("List komponen ".$request->group, $data);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), $th->getStatusCode());
        }
    }
}
