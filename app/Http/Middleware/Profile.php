<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Profile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            $request->session()->flash('messageCheckOut', "<script>
            document.getElementById('id01').style.display = 'block';
            Swal.fire({
                icon: 'warning',
                title: 'Bạn phải đăng nhập trước khi xem thông tin',
                showConfirmButton: false,
                timer: 4000
            })</script>");
            return redirect()->back();
        }
        return $next($request);
    }
}
