<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendEmailOrder($bill)
    {
        $user = $bill->user;
        $products = $bill->products;
        $to_name = "Thế Giới Điện Tử";
        $from_email = $bill->email; //send to this email
        $to_email = "ngovanhung1721010@gmail.com"; //send to this email
        $data = array("user" => $user, "bill" => $bill, 'products' => $products); //body of mail.blade.php
        Mail::send('back_end.admin.mail.order', $data, function ($message) use ($to_name, $to_email, $from_email) {
            $message->to($from_email)->subject('Đặt hàng từ thế giới điện tử'); //send this mail with subject
            $message->from($to_email, $to_name); //send from this mail
        });
        /*   return redirect('/')->with('messageCheckOut', "<script>
        Swal.fire({
            icon: 'warning',
            title: 'gửi mail',
            showConfirmButton: false,
            timer: 4000
        })</script>");
        //--send mail  */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
