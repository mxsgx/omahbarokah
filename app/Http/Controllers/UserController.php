<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Gate;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        Gate::authorize('edit-users', $request->user());

        $users = User::query()->whereNotIn('id', [$request->user()->id]);

        if ($request->ajax()) {
            return datatables()->eloquent($users)
                ->editColumn('role', function ($row) {
                    $roles = [
                        'admin' => 'Admin',
                        'staff' => 'Karyawan',
                        'client' => 'Pelanggan',
                    ];

                    return $roles[strtolower($row->role)];
                })
                ->addColumn('action', function ($row) {
                    $action = [
                        sprintf(
                            '<a href="%s" class="btn btn-sm btn-outline-primary m-1">Ubah</a>',
                            route('admin.user.edit', ['user' => $row->id])
                        ),
                        sprintf(
                            '<form action="%s" method="post"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="%s"><button type="submit" class="btn btn-sm btn-outline-danger m-1">Hapus</button></form>',
                            route('admin.user.delete', ['user' => $row->id]),
                            csrf_token()
                        ),
                    ];

                    return implode(' ', $action);
                })
                ->rawColumns(['action'])->toJson();
        }

        return view('user.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        Gate::authorize('edit-users', $request->user());

        return view('user.create');
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->except(['password']) + [
                'password' => \Hash::make($request->get('password')),
            ]);

        return redirect()->route('admin.user.edit', compact('user'))->with('success', 'Berhasil membuat pengguna baru.');
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request)
    {
        Gate::authorize('edit-users', $request->user());

        return abort(503, 'Maaf halaman ini belum tersedia.');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, User $user)
    {
        Gate::authorize('edit-users', $request->user());

        if ($user->id === $request->user()->id) {
            return redirect()->route('profile.edit');
        }

        return view('user.edit', compact('user'));
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, User $user)
    {
        Gate::authorize('edit-users', $request->user());

        $data = $request->all(['name', 'role', 'email']);

        if ($user->email != $request->get('email')) {
            $data += $this->validate($request, [
                'email' => [
                    'required', 'email', 'unique:users,email',
                ],
            ]);
        }

        $user->update($data);

        return redirect()->route('admin.user.edit', compact('user'))->with('success', 'Berhasil mengubah data pengguna.');
    }

    public function profile(Request $request)
    {
        // TODO: Show profile current logged user or guest profile.
        return abort(503, 'Maaf halaman ini belum tersedia.');
    }

    public function editProfile(Request $request)
    {
        // TODO: Show edit profile page
        return abort(503, 'Maaf halaman ini belum tersedia.');
    }

    public function delete(Request $request, User $user)
    {
        Gate::authorize('edit-users', $request->user());

        if ($user->id === $request->user()->id) {
            return abort(503, 'Tidak dapat menghapus pengguna ini.');
        }

        $user->forceDelete();

        return redirect()->route('admin.user.index')->with('success', 'Berhasil menghapus pengguna.');
    }
}
