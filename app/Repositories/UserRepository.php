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
        return $this->user->latest()->paginate(10);
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
            ->orWhere('phone', 'like', '%' . $request->table_search . '%')->paginate(10);
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
            $s = User::find($request->id);
            $dataUserUpdate = [
                'password' => bcrypt($request->password_new),
            ];
            if (Hash::check($request->password_old, $s->password)) {
                $status = $s->update($dataUserUpdate);
                if ($status) {
                    $request->session()->flash('messageCheckOut', "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Bạn cập nhật mật khẩu thành công',
                    showConfirmButton: false,
                    timer: 4000
                })</script>");
                } else {
                    $request->session()->flash('messageCheckOut', "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Bạn cập nhật mật khẩu không thành công',
                    showConfirmButton: false,
                    timer: 4000
                })</script>");
                }
            } else {
                $request->session()->flash('messageCheckOut', "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Mật khẩu cũ không đúng',
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
}
