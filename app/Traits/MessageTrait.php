<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait MessageTrait
{

    public function successfulMessage($action, $name)
    {
        return "<script>
        Swal.fire({
            icon: 'success',
            title: 'Bạn " . $action . " " . $name . " thành công',
            showConfirmButton: false,
            timer: 4000
        })</script>";
    }

    public function errorMessage($action, $name)
    {
        return "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi hệ thống ! bạn " . $action . " " . $name . " không thành công',
            showConfirmButton: false,
            timer: 4000
        })</script>";
    }

    public function infoMessage($text)
    {
        return "<script>
        Swal.fire({
            icon: 'info',
            title: '" . $text . "',
            showConfirmButton: false,
            timer: 4000
        })</script>";
    }
}
