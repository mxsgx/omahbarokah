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
     */
    public function create(Request $request)
    {
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

    public function show(Request $request)
    {
        // TODO: Show user profile
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, User $user)
    {
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
    }

    public function editProfile(Request $request)
    {
        // TODO: Show edit profile page
    }
}
