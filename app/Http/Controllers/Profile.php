<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Anggota as AnggotaModel;
use App\Models\User as UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Profile extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(?UserModel $user)
    {
        $user = ($user->exists) ? $user : Auth::user();

        return view('profile.show', ['anggota' => $user->anggota]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(?UserModel $user)
    {
        $user = ($user->exists) ? $user : Auth::user();

        return view('profile.edit', ['anggota' => $user->anggota]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, ?UserModel $user)
    {
        $user = ($user->exists) ? $user : Auth::user();

        $data = ['user_id' => $user->getAuthIdentifier(), ...$request->validated()];

        AnggotaModel::updateOrCreate(['user_id' => $user->getAuthIdentifier()], $data);

        return redirect()->route('profile');
    }
}
