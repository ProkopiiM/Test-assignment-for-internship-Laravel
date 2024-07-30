<?php

namespace App\Http\Controllers\AdminDirectory;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagmentUserController extends Controller
{
    /*Поиск сортировка и фильтрация по пользователям*/
    public function index(Request $request)
    {
        $query = $request->input('search');
        $sort = $request->input('sort');
        $paginate = $request->input('paginate',15);
        $role = $request->input('role');
        if (!empty($sort) && ($sort == 'default' || $sort != 'name_asc' && $sort != 'name_desc')) {
            if ($sort == 'date_asc' || $sort == 'date_desc') {
                list($a,$b) = explode('_',$sort);
                $a = 'created_at';
            }
            if ($sort == 'role_asc' || $sort == 'role_desc') {
                list($a,$b) = explode('_',$sort);
                $a = 'role_id';
            }
            if($sort == 'name_asc' || $sort == 'name_desc') {}
            {
                list($a,$b) = explode('_',$sort);
            }
        }
        else
        {
            $a = 'id';
            $b = 'asc';
        }

        $users = User::query()->with('role')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })->when($role, function ($q) use ($role) {
                if ($role != 'all')
                {
                    $q->where('role_id', $role);
                }
            })->when($sort, function ($q) use ($a,$b) {
                $q->orderBy($a, $b);
            })->paginate($paginate);
        $roles = Role::all();
        return view('AdminDirectory.UsersManagment.user-managment')->with(['users'=>$users,'roles'=>$roles]);
    }

    /* добавление новго пользователя / форма для редактирование существующего пользователя*/
    public function create(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            $user = null;
        }
        else
        {
            $user = User::find($id);
        }
        $roles = Role::all();
        return view('AdminDirectory.UsersManagment.user-view')->with(['user'=>$user,'roles'=>$roles]);
    }

    /*удаление пользователя*/
    public function destroy(Request $request)
    {
        $user = User::where('id', $request->input('id'))->firstOrFail();
        if ($user == Auth::guard('admin')->user()) {
            return redirect()->back()->with('error','Вы не можете удалить себя!');
        }
        if($user->role_id < Auth::guard('admin')->user()->role_id)
        {
            return redirect()->back()->with('error','У Вас нет таких полномочий. Сообщите в тех. поддержку об ошибке доступа');
        }
        $user->delete();
        return redirect()->back()->with('status','Пользователь удален');
    }

    /*обновление пользователя*/
    public function update(UpdateUserRequest $request)
    {
        $validate = $request->validated();
        if ($validate['password']) {
            User::where('id', $request->input('id'))->update(['name'=>$validate['name'],
                'email'=>$validate['email'],
                'phone'=>$validate['phone'], 'password'=>bcrypt($validate['password']), 'role_id'=>$request->input('role_id')]);
        }
        else
            User::where('id', $request->input('id'))->update(['name'=>$validate['name'],'email'=>$validate['email'],'phone'=>$validate['phone'], 'role_id'=>$request->input('role_id')]);
        return redirect()->to('/admin-panel/users');
    }

    /*создание пользователя*/
    public function store(RegistrationRequest $request)
    {
        $validate = $request->validated();
        $validate['role_id'] = $request->input('role_id');
        User::create($validate);
        return redirect()->to('/admin-panel/users');
    }
}
