<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\User;
use App\Collager;
use App\QuizCollager;
use Auth;
use DB;
use Spatie\Permission\Models\Role;
use Hash;
use App\Lib\Helper;


class UserController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if (Auth::user()->lpk) {
      $role = Role::orderBy('id', 'desc')->whereNotIn('id',[1])->get();
    } else {
      $role = Role::orderBy('id', 'desc')->get();
    }
    return view('user.index', compact('role'));
  }

  public function getData(Request $request)
  {    
    $filter = $request->filter;
    $lpk = Auth::user()->lpk;
    $data = User::whereHas("roles", function($q) use ($filter) { 
      if($filter != 'All Role'){
        $q->where("name", $filter); 
      }
    })
    ->when($lpk, function ($query, $lpk) {
        return $query->where('lpk', $lpk);
    })
    ->get();
    return datatables()->of($data)->addColumn('action', function($row){
          $btn = '<a href="'.route('user.edit',$row->id).'" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-pencil6"></i></a>';
          if ($row->id != Auth::user()->id) {
            $btn = $btn.'  <button id="delete" class="btn border-warning btn-xs text-warning-600 btn-flat btn-icon"><i class="icon-trash"></i></button>';
          }
          
          return $btn;
    })
    ->rawColumns(['action'])
    ->addIndexColumn()
    ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    if (Auth::user()->lpk) {
      $role = Role::orderBy('id', 'desc')->whereNotIn('id',[1])->get();
    } else {
      $role = Role::orderBy('id', 'desc')->get();
    }
    return view('user.create',compact('role'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    if ($request->role == 3) {
      $this->validate(request(),
        [
          'name' => 'required',
          'username' => 'required|unique:users,username',
          'email' => 'required|unique:users,email',
          'password' => 'required|confirmed',
          'password_confirmation' => 'required',
          'role' => 'required',
          'lpk' => 'required',
          'picture' => 'max:2048|mimes:png,jpg,jpeg',
        ]
      );
    } else {
      $this->validate(request(),
        [
          'name' => 'required',
          'username' => 'required|unique:users,username',
          'email' => 'required|unique:users,email',
          'password' => 'required|confirmed',
          'password_confirmation' => 'required',
          'role' => 'required',
          'picture' => 'max:2048|mimes:png,jpg,jpeg',
        ]
      );
    }
    

    if(!empty($request->picture)){
      $file = $request->file('picture');
      $extension = strtolower($file->getClientOriginalExtension());
      $filename = uniqid() . '.' . $extension;
      \Storage::put('public/images/user/' . $filename, \File::get($file));
    } else {
      $filename = 'avatar.png';
    }

    $user = new User();
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->password = \Hash::make($request->password);
    $user->picture = $filename;
    $user->lpk = $request->lpk;
    $user->save();
    $user->roles()->sync($request->role);

    return redirect()->route('user.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $data = User::with('roles')->find($id);
    return view('user.profile',compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $data = User::find($id);
    if (Auth::user()->lpk) {
      $role = Role::orderBy('id', 'desc')->whereNotIn('id',[1])->get();
    } else {
      $role = Role::orderBy('id', 'desc')->get();
    }
    return view('user.edit',compact('data','role'));
  }

  public function picture($id)
  {
    $user = User::find($id);
    return \Image::make(\Storage::get('public/images/user/'.$user->picture))->response();
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request, $id)
  {
    if ($request->role == 3) {
      $this->validate(request(),
      [
        'name' => 'required',
        'username' => 'required|unique:users,username,'.$id,
        'email' => 'required|unique:users,email,'.$id,
        'password' => 'confirmed',
        'role' => 'required',
        'lpk' => 'required',
        'picture' => 'max:2048|mimes:png,jpg,jpeg',
      ]);
    } else {
      $this->validate(request(),
      [
        'name' => 'required',
        'username' => 'required|unique:users,username,'.$id,
        'email' => 'required|unique:users,email,'.$id,
        'password' => 'confirmed',
        'role' => 'required',
        'picture' => 'max:2048|mimes:png,jpg,jpeg',
      ]);
    }

    $user = User::find($id);

    if(!empty($request->picture)){
      $file = $request->file('picture');
      $extension = strtolower($file->getClientOriginalExtension());
      $filename = uniqid() . '.' . $extension;
      \Storage::delete('public/images/user/' . $user->picture);
      \Storage::put('public/images/user/' . $filename, \File::get($file));
    } else {
      $filename = $user->picture;
    }

    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    if ($request->password) {
      $user->password = \Hash::make($request->password);
    }
    $user->lpk = $request->lpk;
    $user->picture = $filename;
    $user->save();
    $user->roles()->sync($request->role);
    return redirect()->route('user.index');
  }

  public function updateProfil(Request $request, $id)
  {
    $this->validate(request(),
      [
        'name' => 'required',
        'username' => 'required|unique:users,username,'.$id,
        'email' => 'required|unique:users,email,'.$id,
        'picture' => 'max:2048|mimes:png,jpg,jpeg',
      ]
    );

    $user = User::find($id);

    if(!empty($request->picture)){
      $file = $request->file('picture');
      $extension = strtolower($file->getClientOriginalExtension());
      $filename = uniqid() . '.' . $extension;
      \Storage::delete('public/images/user/' . $user->picture);
      \Storage::put('public/images/user/' . $filename, \File::get($file));
    } else {
      $filename = $user->picture;
    }

    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    if ($request->password) {
      $user->password = \Hash::make($request->password);
    }
    $user->picture = $filename;
    $user->save();
    return redirect()->route('user.show',$id);
  }

  public function updatePassword(Request $request, $id)
  {
    $this->validate(request(),
      [
        'password' => 'confirmed'
      ]
    );

    $user = User::find($id);
    if ($request->password) {
      $user->password = \Hash::make($request->password);
    }
    $user->save();
    return redirect()->route('user.show',$id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    \Storage::delete('public/images/user/'.$user->picture);
    $user->delete();

    return response()->json(['data'=>'success delete data']);
  }


  /*START OF API*/

   public function api_collagerRegister(Request $request)
   {
     $request->validate([
       'email' => 'required|string|email|unique:users|max:50',
       'username' => 'required|unique:users|max:20',
       'password' => 'required|string|max:191',
       'name' => 'required|max:50',
     ]);
     DB::beginTransaction();

     $user = User::create([
       // 'id' => Carbon::now()->format('ymd').rand(1000,9999),
       'email'=>$request->email,
       'username'=>$request->username,
       'password'=>bcrypt($request->password),
       'name'=>$request->name,
       'picture'=>'avatar.png',
     ])->assignRole('user');
     if (!$user) {
       DB::rollback();
       return response()->json([
         'status'=>'failed',
         'error'=>'Something wrong!',
         'message'=>'Something wrong!',
       ]);
     }
     $addCollager = Collager::create([
        'user_id' => $user->id,
     ]);
     if (!$addCollager) {
         DB::rollback();
         return response()->json([
             'status'=>'failed',
             'error'=>'Something wrong!',
             'message'=>'Something wrong!',
         ]);
     }
     DB::commit();
     $collager = User::where('id', $user->id)->with('collager')->first();
     return response()->json([
       'status'=>'success',
       'user'=>$collager
     ]);
   }

   public function api_collagerLogin(Request $request){
    if(Auth::attempt([
      'email' => request('email'),
      'password' => request('password'),

    ]))
    {
        $user = Auth::user();
        if ($user->hasRole('user')) {
          $email = $request->get('email');
          $password = $request->get('password');

          $success['token'] =  $user->createToken('MyApp')-> accessToken;
          $success['email'] = $email;
          $success['password'] = $password;

          $collager = User::where('email', $success['email'])->with('collager')->first();
          $collager->token = $success['token'];
          // $collager->foto= asset('images/'.$collager->foto.'');

          return response()->json([
              'status'=>'success',
              'user' => $collager
          ]);
        }
        else {
          $success['status'] = 'failed';
          $success['error'] = 'Unauthorised';
          $success['message'] = 'Your email or password incorrect!';
          return response()->json($success,401);
        }
    }
    else{
        $success['status'] = 'failed';
        $success['error'] = 'Unauthorised';
        $success['message'] = 'Your email or password incorrect!';
        return response()->json($success,401);
    }
  }

  public function api_logout(Request $request)
   {
     $request->user()->token()->revoke();
     return response()->json([
       'message' => 'Successfully logged out'
     ]);
   }

  public function api_index()
  {
      $users = User::with('collager')->where('id', Auth::user()->id)->first();
      // if($users->picture == 'avatar.png'){
      //   $users->picture = asset('img/'.$users->picture.'');
      // }else {
      //   $users->picture = route('user.picture',$users->id);
      // }
      $countPlayed= QuizCollager::where('collager_id', Auth::user()->collager->id)->get()->count();
      $highScore= QuizCollager::where('collager_id', Auth::user()->collager->id)->get()->max('total_score');
      $users->count_played = $countPlayed;
      $users->high_score = $highScore;
      return response()->json([
        'status'=>'success',
        'user' => $users
      ]);
  }
  public function api_update(Request $request)
  {
    $data= User::where('id',Auth::user()->id)->first();
    $this->validate($request,
    [
      'email' => 'required|string|email|unique:users,email,'.$data->id.',id|max:50',
      'username' => 'required|unique:users,username,'.$data->id.',id|max:20',
      'name' => 'required|max:50',
    ]);
    $data->email=$request->email;
    $data->username=$request->username;
    $data->name=$request->name;
    $data->save();
    if($data->picture == 'avatar.png'){
      $data->picture = asset('img/'.$data->picture.'');
    }else {
      $data->picture = route('user.picture',$data->id);
    }
    return response()->json([
      'status'=>'success',
      'user'=>$data,
    ]);
  }

  public function api_updatePassword(Request $request)
  {
    $data= User::find(Auth::user()->id);
    if(Hash::check($request->password_current,$data->password)){
      $data->password = Hash::make($request->password);
      $this->validate($request,
        [
          'password_current' => 'required',
          'password' => 'required|string|min:8|confirmed|max:191',
          'password_confirmation' => 'required',
        ]);
      $data->save();
      return response()->json([
        'status'=>'success',
        'user'=>$data
      ]);
    }
    else{
      return response()->json([
        'status'=>'failed',
        'message'=>'Incorrect current password.'
      ]);
    }
  }

  public function api_uploadAvatar(Request $request)
  {
    $data= User::find(Auth::user()->id);
    $path = base_path().'/storage/app/public/images/user/';
    $photo = Helper::uploadPhoto($request->picture,$path);
    \Storage::delete('public/images/user/' . $data->picture);
    $data->picture = $photo['image_name'];
    $data->save();
    return response()->json([
      'status'=>'success',
      'user'=>$data
    ]);
  }
}

?>
