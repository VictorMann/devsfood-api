<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
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
        $users = User::get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'string|required',
            'email'     => 'unique:users',
            'password'  => 'string|required',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => json_encode($validator->errors())
            ]);
        }

        try
        {
            $user = new User($request->only('name', 'email'));
            $user->password = bcrypt($request->password);
            $user->save();

            $token = auth('api')->login($user);

            return response()->json([
                'error'  => '',
                'result' => [
                    'data'  => $user,
                    'token' => $token
                ]
            ]);
        }
        catch (\Exception $ex)
        {
            return response()->json([
                'error'  => 'ERROR: ' . $ex->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'string|required',
            'email'     => 'string|required',
            'password'  => 'string|nullable',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'error' => json_encode($validator->errors())
            ]);
        }

        try
        {
            $user = $request->user();

            $emailExiste = User::where('email', $request->email)
            ->where('id', '<>', $user->id)
            ->first();

            if ($emailExiste)
            {
                return response()->json([
                    'error' => 'este email já existe tente outro.'
                ]);
            }

            $data = $request->only('name', 'email');
            $user->fill($data);

            $user->password = $request->password
            ? bcrypt($request->password)
            : $user->password;

            $user->save();

            return response()->json([
                'error' => '',
                'result' => $user
            ]);
        }
        catch (\Exception $ex)
        {
            return response()->json([
                'error'  => 'ERROR: ' . $ex->getMessage()
            ]);
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
        //
    }
}
