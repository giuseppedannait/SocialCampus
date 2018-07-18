<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
Use App\SocialChannel;

Use Auth;

use DB;
use Illuminate\Http\Request;
Use App\Http\Controllers\SuperAdminController;
Use App\Http\Controllers\AdminController;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:SMM,SOCIAL_SUPER_ADMIN');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset(Auth::user()->roles->first()->name))
        {
            if (Auth::user()->roles->first()->name === 'SOCIAL_SUPER_ADMIN')
            {
                $users = User::with('roles')->latest()->paginate();
                $roles = Role::all();
            }
            elseif (Auth::user()->roles->first()->name === 'SMM')
            {
                $users = User::with('roles')->where('id_smm', '=', Auth::user()->id )->paginate();
                $roles = Role::all();
            }
            else
            {
                return view('home');
            }
        }

        return view('users.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $associates = User::whereHas('roles', function ($q) {
            $q->where('name', '=', 'SMM');
        })->get();
        $selectedRole = 'SOCIAL_USER';

        return view('users.create', ['roles' => $roles, 'selectedRole' => $selectedRole, 'associates' => $associates]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //User::create($request->all());
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));

        $user->save();

        $role = $request->get('role');

        $user->roles()->sync($role);

        return redirect()->route('users.index')->with('success','Utente creato correttamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $associates = DB::table('users')->where('id_smm', '=', $user->id)->get();
        $smm = DB::table('users')->where('id', '=', $user->id_smm)->first();

        $channels = SocialChannel::with('socials')->latest()->where('user_id', $user->id)->orderBy('name')->paginate();

        return view('users.show', ['user' => $user, 'associates' => $associates, 'smm' => $smm, 'channels' => $channels]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = User::with('roles')->where('id', $user->id)->first();
        $selectedRole = @$user->roles->first()->name;

        $roles = Role::all();
        $associates = User::whereHas('roles', function ($q) {
            $q->where('name', '=', 'SMM');
        })->get();

        return view('users.update', ['user' => $user, 'roles' => $roles, 'selectedRole' => $selectedRole, 'associates' => $associates]);
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
        // $this->validate($request,$this->rules($user->id));

        // return $this->save($request,$user);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = $request->get('password');

        $user->id_smm = $request->get('associate');

        $user->save();

        $role = $request->get('role');

        $user->roles()->sync($role);

        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->delete())
        {
            session()->flash('status', 'Utente eliminato correttamente.');
        }
        else
        {
            session()->flash('status', "Impossibile eliminare l'utente. Riprovare.");
        }

        //return redirect('users');
        return response()->json(['success'=>"Utente cancellato correttamente.", 'tr'=>'tr_'.$id]);
    }

    private function rules(User $user = null)
    {
        $rules = [
            'name'     => 'required|min:4',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8'
        ];

        if ($user) {
            $rules['email']    = 'required|email|unique:users,id,'.$user['id'];
            $rules['password'] = 'sometimes|min:8';
        }

        return $rules;
    }

    private function save(Request $request, User $user = null) {

        $status = "update";

        if (! $user) {
            $user = new User;
            $status = "create";
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($user->save()) {
            session()->flash('status', 'User '.$status.'d successfully');
            return redirect(route('users'));
        }

        session()->flash('status', 'Unable to '.$status.' user. Please try again');
        return back()->withInput();
    }
}
