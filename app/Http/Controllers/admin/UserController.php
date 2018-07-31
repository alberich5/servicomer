<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Caffeinated\Shinobi\Models\Role;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate();
        

        return view('users.index', compact('users'));
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::get();

        return view('users.edit', compact('user', 'roles'));
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
        $user = User::find($id);
        $user->update($request->all());

        $user->roles()->sync($request->get('roles'));

        return redirect()->route('users.edit', $user->id)
            ->with('info', 'Usuario guardado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return back()->with('info', 'Eliminado correctamente');
    }



    public function store(Request $request)
    {


            $user=User::where('username',$request['username'])
            ->get();


           if(empty($user))
           {
           dd($user);
            return redirect()->route('usuario.registrar')->with('info', 'Verifique la disponibilidad del username');
           }
           else
           {
            User::create([
            'username' => $request['username'],
            'password' => bcrypt($request['password'])
             ]);


             return redirect()->route('users.index')->with('info', 'Agregado correctamente');
           }



           //$usuario = User::create(['username' =>$request['username'],'password' => bcrypt($request['password'])]);
           


            //return back()->with('info', 'Agregado correctamente');
    }


public function create()
    {
         return view('auth.register');
    }


    
}
