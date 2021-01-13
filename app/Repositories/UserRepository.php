<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use App\Traits\StorageImageTrait;
use App\Traits\MessageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserRepository
{

    protected $user;
    protected $role;
    use StorageImageTrait;
    use MessageTrait;
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function getRoles()
    {
        return $this->role->all();
    }
    public function getAll()
    {
        return $this->user->latest()->get();
    }


    public function show($request)
    {
        $user = $this->user->find($request->id);
        return [$user, $user->roles];
    }


    public function update($request, $id)
    {
    }

    public function destroy($id)
    {
        try {
            $user = $this->user->find($id);
            $user->delete();
            return response()->json([
                'code' => 200,
                'message' => "success",
            ], 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => "fail",
            ], 500);
        }
    }

    public function search($request)
    {
        return $this->user->where('name', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')
            ->orWhere('phone', 'like', '%' . $request->table_search . '%')->get();
    }

    public function updateRole($request)
    {
        $user = $this->user->find($request->id);
        $user->roles()->sync($request->role_ids);
    }

    public function updateInfo($request)
    {
        try {
            $dataUserUpdate = [
                'email' => $request->email,
                'address' => $request->address,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'phone' => $request->phone
            ];

            $s = User::find($request->id);
            $status = $s->update($dataUserUpdate);
            if ($status) {
                $request->session()->flash('messageCheckOut', "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn cập nhật thông tin thành công',
                    showConfirmButton: false,
                    timer: 4000
                })</script>");
            } else {
                $request->session()->flash('messageCheckOut', "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Bạn cập nhật thông tin không thành công',
                    showConfirmButton: false,
                    timer: 4000
                })</script>");
            }
            return redirect()->route('profile');
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            $request->session()->flash('messageCheckOut', "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống !',
                    showConfirmButton: false,
                    timer: 4000
                })</script>");
            return redirect()->route('profile');
        }
    }

    public function updatePassword($request)
    {
        try {
            $rules = [
                'password_new' => 'required|min:6|max:30',
                'password_old' => 'required',
                'repassword_new' => 'required|same:password_new'
            ];
            $messages = [
                'password_new.required' => 'Bạn chưa nhập mật khẩu mới',
                'password_new.min' => 'Mật khẩu mới không ít hơn 6 ký tự',
                'password_new.max' => 'Mật khẩu mới không lớn hơn 30 ký tự',
                'password_old.required' => 'Bạn chưa nhập mật khẩu cũ',
                'repassword_new.required' => 'Bạn chưa nhập mật khẩu mới lần 2',
                'repassword_new.same' => 'Mật khẩu không khớp'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $s = User::find($request->id);
            $dataUserUpdate = [
                'password' => bcrypt($request->password_new),
            ];
            if (Hash::check($request->password_old, $s->password)) {
                $s->update($dataUserUpdate);
                return response()->json(array('success' => true), 200);
            } else {
                return response()->json(array('success' => false), 200);
            }
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function updateImageUser($request)
    {
        try {
            $rules = [
                'image_icon' => 'required|mimes:jpg,jpeg,png,gif|max:10240',
            ];
            $messages = [
                'image_icon.required' => 'Bạn chưa chọn hình ảnh',
                'image_icon.mimes' => 'Chỉ chấp nhận hình với đuôi .jpg .jpeg .png .gif',
                'image_icon.max' => 'Hình giới hạn dung lượng không quá 10M',

            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataImageUpdate = [];
            $user = User::find($request->id);
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image_icon', 'user', 'user');
            if (!empty($dataUploadFeatureImage)) {
                $dataImageUpdate['image_icon'] = $dataUploadFeatureImage['file_path'];
                ///storage/user/user/KreoWWLtLf3ZhBQGwu1p.png
                if ('/storage/user/user/KreoWWLtLf3ZhBQGwu1p.png' != $user->image_icon) {
                    $filename = str_replace('/storage/user/user/', '', $user->image_icon);
                    // remove old image
                    unlink(storage_path('app/public/user/user/' . $filename));
                }
            }
            $user->update($dataImageUpdate);
            return response()->json(array('success' => true, 'image' => $user->image_icon), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }
}
