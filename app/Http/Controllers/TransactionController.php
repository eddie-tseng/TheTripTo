<?php

namespace App\Http\Controllers;

use Validator;
use App\Entities\Tour;
use App\Entities\Order;
use DB;
use Exception;
use \Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Order a tour
     *
     * @return RedirectResponse
     */
    public function orderTour()
    {
        $input = request()->all();
        $tour_id = $input['tour_id'];

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

            DB::beginTransaction();

            $tour = Tour::findOrFail($tour_id);
            $user_id = session()->get('user_id');

            #check inventory
            $remain_count = $tour->inventory - $input['quantity'];
            if ($remain_count < 0) {
                throw new Exception('商品數量不足，無法購買');
            }
            #end

            #update inventory
            $tour->inventory = $remain_count;
            $tour->save();
            #end

            #create order
            $order_data = [
                'travel_date' => $input['travel_date'],
                'quantity' => $input['quantity'],
                'status' => 'c',
                'price' => $tour->price,
                'payment' => 'cc',
            ];

            $order = new Order($order_data);
            $order->user()->associate($user_id);
            $order->tour()->associate($tour_id);
            $order->save();
            #end

            DB::commit();

            return redirect('/users/' . $user_id . '/orders');
        } catch (Exception $exception) {

            DB::rollBack();

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

    /**
     * Get comment page
     *
     * @param int $order_id
     * @return View
     */
    public function commentPage($order_id)
    {
        $order = order::findOrFail($order_id);
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

    /**
     * Past a comment
     *
     * @param int $order_id
     * @return View
     */
    public function postComment($order_id)
    {
        $Order = Order::findOrFail($order_id);

        $input = request()->except(['_token']);

        $rules = [
            'content' => 'required|max:500',
            'rating' => 'required|max:5|min:1',
        ];

        // 驗證資料
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            // 資料驗證錯誤
            return redirect('/orders/' . $order_id . '/comment')
                ->withErrors($validator)
                ->withInput();
        }

        $input = array_merge(
            $input,
            [
                'created_at' => Carbon::now()
            ]
        );

        $Order->comment()->firstOrCreate($input);

        return redirect()->intended('/tours/' . $Order->tour->id);
    }
}
