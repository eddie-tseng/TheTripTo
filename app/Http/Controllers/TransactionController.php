<?php

namespace App\Http\Controllers;

use Mail;
use Socialite;
use Validator;  // 驗證器
use Hash;       // 雜湊
use App\Entities\Tour;   // 使用者 Eloquent Model
use App\Entities\Order;
use App\Entities\Comment;
use App\Entities\User;
use DB;
use Exception;
use \Carbon\Carbon;

class TransactionController extends Controller
{
    public function orderTour()
    {
        $input = request()->all();
        $tour_id = $input['tour_id'];
        // unset($input['tour_id']);

        $rules = [
            'travel_date' => 'required|date_format:Y-m-d|after:strtotime("now")',
            'quantity' => 'required|min:1',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect('/tours/' . $tour_id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // 交易開始
            DB::beginTransaction();
            // 取得商品資料
            $tour = Tour::findOrFail($tour_id);
            $user_id = session()->get('user_id');
            // 購買數量
            //$quantity = $input['quantity'];
            // 購買後剩餘數量
            $remain_count = $tour->inventory - $input['quantity'];
            if ($remain_count < 0) {
                // 購買後剩餘數量小於 0，不足以賣給使用者
                throw new Exception('商品數量不足，無法購買');
            }
            // 紀錄購買後剩餘數量
            $tour->inventory = $remain_count;
            $tour->save();

            // 建立交易資料
            $booking_data = [
                'travel_date' => $input['travel_date'],
                'quantity' => $input['quantity'],
                'status' => 'c',
                'price' => $tour->price,
                'payment' => 'cc',
            ];

            $order = new Order($booking_data);
            $order->user()->associate($user_id);
            $order->tour()->associate($tour_id);
            $order->save();

            // 交易結束
            DB::commit();
            return redirect('/users/' . $user_id . '/orders');
        } catch (Exception $exception) {
            // 恢復原先交易狀態
            DB::rollBack();

            // 回傳錯誤訊息
            $error_message = [
                'msg' => [
                    $exception->getMessage(),
                ],
            ];

            return redirect()
            ->back()
            ->withErrors($error_message)
            ->withInput();
        }
    }

    public function bookingPage()
    {
        $id = session()->get('user_id');

        $User = User::findOrFail($id);
        session()->reflash();
        $binding = [
            'User' => $User,
        ];

        return view('transaction.booking', $binding);
    }

    public function createBooking()
    {
        // 檢查遊客資料
        $input = request()->all();
        $tourist_datas = $input['booking'];
        $quantity = session()->get('booking.quantity');
        $rules = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'mail' => 'required|max:150|email',
            'phone' => 'required',
            'country' => 'max:20',
            'birth_date' => 'date',
            'gender' => 'in:m,f',
        ];

        $tourist_names = [];
        $is_same_name = false;

        foreach ($tourist_datas as $value) {

            // 驗證資料
            $validator = Validator::make($value, $rules);

            $tourist_name = $value['first_name'] . $value['last_name'];

            if (in_array($tourist_name, $tourist_names)) {
                $is_same_name = true;
            } else {
                array_push($tourist_names, $tourist_name);
            }

            if ($validator->fails() || $is_same_name) {
                if ($is_same_name) {
                    $validator->errors()->add('tourist_name', '旅客姓名重複!');
                }

                session()->reflash();

                return redirect('/transaction/')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        try {
            // 取得登入會員資料
            $user_id = session()->get('user_id');
            $tour_id = session()->get('tour_id');
            $quantity = session()->get('booking.quantity');


            // 交易開始
            DB::beginTransaction();
            // 取得商品資料
            $Tour = Tour::findOrFail($tour_id);

            // 購買數量
            //$quantity = $input['quantity'];
            // 購買後剩餘數量
            $remain_count = $Tour->inventory - $quantity;
            if ($remain_count < 0) {
                // 購買後剩餘數量小於 0，不足以賣給使用者
                throw new Exception('商品數量不足，無法購買');
            }
            // 紀錄購買後剩餘數量
            $Tour->inventory = $remain_count;
            $Tour->save();

            // 建立交易資料
            $booking_data = [
                'travel_date' => session()->get('booking.travel_date'),
                'quantity' => $quantity,
                'status' => 'c',
                'price' => $Tour->price,
                'payment' => $input['payment'],
            ];

            $Order = new Order($booking_data);
            $Order->user()->associate($user_id);
            $Order->tour()->associate($tour_id);
            $Order->save();

            // 建立遊客資料
            foreach ($tourist_datas as $value) {
                $Order->tourists()->firstOrCreate($value);
            }
            // 交易結束
            DB::commit();
            return redirect()
                ->to('/orders/' . $Order->id);
        } catch (Exception $exception) {
            // 恢復原先交易狀態
            DB::rollBack();

            // 回傳錯誤訊息
            $error_message = [
                'msg' => [
                    $exception->getMessage(),
                ],
            ];
            return redirect()
                ->back()
                ->withErrors($error_message)
                ->withInput();
        }
    }

    public function bookingResult($id)
    {
        $order = Order::findOrFail($id);

        $binding = [
            'Order' => $order,
        ];

        return view('transaction.booking-complete', $binding);
    }

    public function commentPage($id)
    {
        $order = order::findOrFail($id);
        $comment = $order->comment()->first();
        $tour = $order->tour()->first();

        if ($order->user_id != session()->get('user_id') || !is_null($comment)) {
            return redirect('/');
        }

        $binding = [
            'order' => $order,
            'tour' => $tour,
            'title' => '旅遊評論'
        ];

        return view('transaction.comment', $binding);
    }

    public function postComment($id)
    {
        $Order = Order::findOrFail($id);

        $input = request()->except(['_token']);

        $rules = [
            'content' => 'required|max:500',
            'rating' => 'required|max:5|min:1',
        ];

        // 驗證資料
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            // 資料驗證錯誤
            return redirect('/orders/' . $id . '/comment')
                ->withErrors($validator)
                ->withInput();
        }

        $input = array_merge(
            $input,
            [
                'created_at' => Carbon::now()
            ]
        );
        // Comment::create($input);
        // $comment = new Comment($input);
        // $Order->comment()->save($comment);
        $Order->comment()->firstOrCreate($input);
        // $Order->save();
        // 重新導向到原先使用者造訪頁面，沒有嘗試造訪頁則重新導向回首頁
        return redirect()->intended('/tours/' . $Order->tour->id);
    }
}
