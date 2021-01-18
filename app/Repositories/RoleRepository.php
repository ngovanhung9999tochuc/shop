<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleRepository
{

    protected $role;
    protected $permission;
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function getAll()
    {
        return $this->role->latest()->get();
    }


    public function create($request)
    {
        try {
            $rules = [
                'name' => 'required|unique:roles|regex:/(^[\pL0-9 ]+$)/u',
            ];
            $messages = [
                'name.required' => 'Tên vai trò không được phép trống',
                'name.unique' => 'Tên vai trò đã được sử dụng',
                'name.regex' => 'Tên vai trò không được phép có ký tự đặc biệt',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataRoleCreate = [
                'name' => $request->name,
                'display_name' => $request->display_name,
            ];

            $id = $this->role->create($dataRoleCreate)->id;
            $role = $this->role->find($id);
            return response()->json(array('success' => true, 'role' => $role), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function update($request)
    {
        try {
            $rules = [
                'name' => 'required|regex:/(^[\pL0-9 ]+$)/u',
            ];
            $messages = [
                'name.required' => 'Tên vai trò không được phép trống',
                'name.regex' => 'Tên vai trò không được phép có ký tự đặc biệt',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }

            $dataRoleUpdate = [
                'name' => $request->name,
                'display_name' => $request->display_name,
            ];

            $this->role->find($request->id)->update($dataRoleUpdate);
            $role = $this->role->find($request->id);
            return response()->json(array('success' => true, 'role' => $role), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            $anchor = true;
            $message = '';
            $data = [];
            $users = $role->users;
            if (count($users) != 0) {
                $count = count($users);
                $anchor = false;
                $message = 'Bạn không thể xóa, vai trò hiện tại đang phân quyền cho ' . $count . ' người dùng';
                foreach ($users as  $user) {
                    $data[$user->id]['id'] = $user->id;
                    $data[$user->id]['name'] = $user->name;
                    $data[$user->id]['username'] = $user->username;
                }
            }

            if ($anchor) {
                $role->delete();
                return response()->json([
                    'code' => 200,
                    'message' => "success",
                ], 200);
            } else {
                return response()->json([
                    'code' => 500,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
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
        return $this->role->where('name', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')->paginate(10);
    }

    public function edit($request)
    {
        try {
            $role = $this->role::find($request->id);
            return response()->json(array('success' => true, 'role' => $role), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function getListPermission($request)
    {
        try {

            $htmlList = '';
            $permissions = $this->permission->all();
            $role = $this->role->find($request->id);
            $permissions_roles = $role->permissions;
            $length = count($permissions);
            $mid = round($length / 2, 0, PHP_ROUND_HALF_UP);
            $i = 0;
            $htmlList .= '<ul class="col-md-6 list-group list-group-flush">';
            for ($i; $i < $mid; $i++) {
                $check = '';
                if ($permissions_roles->contains('id', $permissions[$i]->id)) {
                    $check = 'checked';
                }
                $htmlList .= '<li class="list-group-item">';
                $htmlList .= '<div class="custom-control custom-checkbox">';
                $htmlList .= '<input type="checkbox" ' . $check . ' name="permission_id[]" class="custom-control-input" value="' . $permissions[$i]->id . '" id="' . $permissions[$i]->id . $permissions[$i]->key_code . '">';
                $htmlList .= '<label class="custom-control-label" for="' . $permissions[$i]->id . $permissions[$i]->key_code . '">Module ' . $permissions[$i]->display_name . '</label>';
                $htmlList .= '</div>';
                $htmlList .= '</li>';
            }
            $htmlList .= '</ul>';

            $htmlList .= '<ul class="col-md-6 list-group list-group-flush">';
            for ($i; $i < $length; $i++) {
                $check = '';
                if ($permissions_roles->contains('id', $permissions[$i]->id)) {
                    $check = 'checked';
                }
                $htmlList .= '<li class="list-group-item">';
                $htmlList .= '<div class="custom-control custom-checkbox">';
                $htmlList .= '<input type="checkbox" ' . $check . ' name="permission_id[]" class="custom-control-input" value="' . $permissions[$i]->id . '" id="' . $permissions[$i]->id . $permissions[$i]->key_code . '">';
                $htmlList .= '<label class="custom-control-label" for="' . $permissions[$i]->id . $permissions[$i]->key_code . '">Module ' . $permissions[$i]->display_name . '</label>';
                $htmlList .= '</div>';
                $htmlList .= '</li>';
            }
            $htmlList .= '</ul>';
            return response()->json(array('success' => true, 'htmlList' => $htmlList, 'id' => $role->id), 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function updateListPermission($request)
    {
        try {
            if ($request->id == 2) {
                return response()->json(array('success' => false), 200);
            } else {
                $role = $this->role->find($request->id);
                $role->permissions()->sync($request->permission_id);
                return response()->json(array('success' => true), 200);
            }
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }
}
