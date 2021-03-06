<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Visitor;
use App\Repositories\HomeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Float_;

class HomeController extends Controller
{
    protected $repository;

    public function __construct(HomeRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHome(Request $request)
    {
        $user_ip_address = $request->ip();
        $visitor_current = Visitor::where('id_address', $user_ip_address)->where('date_visitors', date('Y-m-d'))->get();
        $visitor_count = $visitor_current->count();
        if ($visitor_count == 0) {
            $visitor = new Visitor();
            $visitor->id_address = $user_ip_address;
            $visitor->date_visitors = date('Y-m-d');
            $visitor->save();
        }
        $products = $this->repository->getHome();
        return view('front_end.page.home', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPageTypeProduct($type, $id)
    {
        if ($type == '11') {
            switch ($id) {
                case 1:
                    return redirect()->route('home');
                    break;
                case 10:
                    return redirect()->route('home');
                    break;
                default:
                    return redirect()->route('home');
            }
        } else {

            return view('front_end.page.products', $this->repository->getPageTypeProduct($type, $id));
        }
    }


    public function getProductPrice($type, $price)
    {
        return view('front_end.page.products', $this->repository->getProductPrice($type, $price));
    }


    public function getTypeProduct($id)
    {
        return view('front_end.page.products', $this->repository->getTypeProduct($id));
    }

    public function getProductDetail($id)
    {
        return view('front_end.page.single_product', $this->repository->getProductDetail($id));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function enterAnOrder(OrderRequest $request)
    {
        return  $this->repository->enterAnOrder($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getOrder()
    {
        $cart = $this->repository->getOrder();
        return view('front_end.page.cart', $cart);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
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
    public function searchProduct(Request $request)
    {
        $products = $this->repository->searchProduct($request);
        return view('front_end.page.search', ['products' => $products]);
    }

    public function getProfile()
    {
        return view('front_end.page.profile');
    }

    public function getBillProduct(Request $request)
    {
        return  $this->repository->getBillProduct($request);
    }

    public function rating(Request $request)
    {
        if (Auth::check()) {
            $this->validate(
                $request,
                [
                    'review' => 'required|min:40'
                ],
                [
                    'review.min' => 'Đánh giá không ít hơn 40 ký tự',
                    'review.required' => 'Bạn chưa nhập đánh giá'
                ]
            );
            return  $this->repository->rating(true, $request);
        } else {
            $this->validate(
                $request,
                [
                    'email' => 'required|email',
                    'password' => 'required|min:6|max:30',
                    'review' => 'required|min:40'
                ],
                [
                    'email.required' => 'Bạn chưa nhập tài khoản',
                    'email.email' => 'Không đúng định dạng email',
                    'password.required' => 'Bạn chưa nhập mật khẩu',
                    'password.min' => 'Mật khẩu không ít hơn 6 ký tự',
                    'password.max' => 'Mật khẩu không lớn hơn 30 ký tự',
                    'review.min' => 'Đánh giá không ít hơn 40 ký tự',
                    'review.required' => 'Bạn chưa nhập đánh giá'
                ]
            );
            return  $this->repository->rating(false, $request);
        }
    }
}
