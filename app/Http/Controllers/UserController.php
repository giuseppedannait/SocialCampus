<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
Use App\Http\Controllers\SuperAdminController;
Use App\Http\Controllers\AdminController;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate();
        return view('users.index', compact('users',$users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::create($request->all());
        return redirect()->route('users.index')
                ->with('success','Utente creato correttamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user', $user));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.update', compact('user', $user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,$this->rules($user->id));

        return $this->save($request,$user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            session()->flash('status', 'User deleted successfully');
        } else {
            session()->flash('status', 'Unable to delete user. Please try again');
        }

        return back();
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
