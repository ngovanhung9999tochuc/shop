<?php

namespace App\Repositories;


use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LoginRepository
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($request)
    {
        try {
            $rules =  [
                'email' => 'required|email',
                'password' => 'required|min:6|max:30',
            ];
            $messages =   [
                'email.required' => 'Bạn chưa nhập tài khoản',
                'email.email' => 'Không đúng định dạng email',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu không ít hơn 6 ký tự',
                'password.max' => 'Mật khẩu không lớn hơn 30 ký tự',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            if (Auth::attempt([
                'username' => $request->email,
                'password' => $request->password
            ])) {
                $user = auth()->user();
                $checkAdmin = Gate::allows('admin');
                return response()->json(array('success' => true, 'user' => $user, 'checkAdmin' => $checkAdmin), 200);
            } else {
                return response()->json(array('success' => false, 200));
            }
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function register($request)
    {
        //  /storage/user/KreoWWLtLf3ZhBQGwu1p.png
        try {
            $rules =  [
                'username' => 'required|email|unique:users',
                'password' => 'required|min:6|max:30',
                'fullname' => 'required',
                'repassword' => 'required|same:password'
            ];
            $messages =   [
                'username.required' => 'Bạn chưa nhập email',
                'username.email' => 'Không đúng định dạng email',
                'username.unique' => 'Email đã có người sử dụng',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu không ít hơn 6 ký tự',
                'password.max' => 'Mật khẩu không lớn hơn 30 ký tự',
                'fullname.required' => 'Bạn chưa nhập tên',
                'repassword.required' => 'Bạn chưa nhập mật khẩu lần 2',
                'repassword.same' => 'Mật khẩu không khớp'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }
            $user = new User();
            $user->name = $request->fullname;
            $user->username = $request->username;
            $user->email = $request->username;
            $user->image_icon = '/storage/user/user/KreoWWLtLf3ZhBQGwu1p.png';
            $user->password = bcrypt($request->password);
            $user->save();
            $user->roles()->attach([1]);
            $id = $user->id;
            $users = User::find($id);
            if (Auth::attempt([
                'username' => $users->username,
                'password' => $request->password
            ])) {
                return response()->json(array('success' => true, 'user' => $users), 200);
            } else {
                return response()->json(array('success' => false), 200);
            }
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function deleteItemToCart($request)
    {
    }

    public function destroy($id)
    {
    }

    public function search($request)
    {
    }
}
