<?php

namespace App\Http\Controllers\Central;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Anggota as AnggotaModel;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('central.profile.show', ['anggota' => Auth::user()->anggota]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSpecific(AnggotaModel $anggota)
    {
        return view('central.profile.show', [
            'anggota' => $anggota,
            'edit_href' => route('profile.edit.specific', $anggota->id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('central.profile.edit', ['anggota' => Auth::user()->anggota]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSpecific(AnggotaModel $anggota)
    {
        return view('central.profile.edit', [
            'anggota' => $anggota,
            'form_action' => route('profile.specific', $anggota->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        $data = ['user_id' => Auth::id(), ...$request->validated()];

        AnggotaModel::updateOrCreate(['user_id' => Auth::id()], $data);

        return redirect()->route('profile')
            ->with('alert', [
                ['mode' => 'success', 'message' => 'Perubahan profile berhasil disimpan'],
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSpecific(UpdateProfileRequest $request, AnggotaModel $anggota)
    {
        $data = ['user_id' => $anggota->user_id, ...$request->validated()];

        AnggotaModel::updateOrCreate(['user_id' => $anggota->user_id], $data);

        return redirect()->route('profile.specific', $anggota->id)
            ->with('alert', [
                ['mode' => 'success', 'message' => 'Perubahan profile berhasil disimpan'],
            ]);
    }
}
