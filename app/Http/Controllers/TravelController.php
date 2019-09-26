<?php

namespace App\Http\Controllers;

use Mail;
use Socialite;
use Validator;  // 驗證器
use Hash;       // 雜湊
use App\Entities\Tour;   // 使用者 Eloquent Model
use App\Entities\AvailableDates;
use App\Entities\Order;
use App\Entities\User;
use App\Service\TourService;
use DB;
use Exception;
use Image;

class TravelController extends Controller
{
    //建立新行程
    public function createTour()
    {
        // 建立商品基本資訊
        $tour_data = [
            'title' => '',
            'status' => 'c',
            'photo' => "/img/cant-find-500x500.jpg",
            'introduction' => '',
            'sub_title' => '',
            'price' => 0,
            'sub_title_count_total' => 0,
            'inventory' => 0,
            'country' => '',
            'city' => '',
            'latitude' => 0,
            'longitude' => 0,
        ];
        $Tour = Tour::create($tour_data);

        // 重新導向至商品編輯頁
        return redirect('/tours/' . $Tour->id . '/edit');
    }

    // 商品編輯頁
    public function tourItemEditPage($id)
    {
        // 撈取商品資料
        $Tour = Tour::findOrFail($id);
        //$AvailableDates = $Tour->AvailableDates;
        // if (!is_null($Tour->photo)) {
        //     // 設定商品照片網址
        //     $Tour->photo = url($Tour->photo);
        // }

        $binding = [
            'Tour' => $Tour,

        ];
        return view('tour.tours-editer', $binding);
    }

    //更新行程資料
    public function updateTour($id)
    {
        // Get user profile

        $Tour = Tour::findOrFail($id);
        // 接收輸入資料
        $input = request()->all();

        // 驗證規則
        $rules = [
            'title' => 'required|max:100',
            'status' => 'in:c,r', // C:create, R:ready
            'photo' => 'max: 10240',
            'introduction' => 'required',
            'sub_title' => 'required|max:100',
            'price' => 'required|min:0',
            'inventory' => 'required|min:0',
            'country' => 'required|max:100',
            'city' => 'required|max:100',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        // 驗證資料
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            // 資料驗證錯誤
            return redirect('/tours/' . $Tour->id)
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($input['photo'])) {
            // 有上傳圖片
            $photo = $input['photo'];
            // 檔案副檔名
            $file_extension = $photo->getClientOriginalExtension();
            // 產生自訂隨機檔案名稱
            $file_name = uniqid() . '.' . $file_extension;
            // 檔案相對路徑
            $file_relative_path = 'img/tour/' . $file_name;
            // 檔案存放目錄為對外公開 public 目錄下的相對位置
            $file_path = public_path($file_relative_path);
            // 裁切圖片
            Image::make($photo)->save($file_path);
            // 設定圖片檔案相對位置
            $input['photo'] = $file_relative_path;
        }

        // 商品資料更新
        $Tour->update($input);

        $dates = explode(",", $input['available_date']);

        foreach ($dates as $val) {
            //$date = new AvailableDates(['available_date' => $val]);

            $Tour = Tour::find($id);
            $Tour->AvailableDates()->firstOrCreate(['available_date' => $val]);
        }

        // 重新導向到商品編輯頁
        return redirect('/tours/' . $Tour->id);
    }

    //行程頁
    public function tourPage($tour_id)
    {
        $tour = Tour::findOrFail($tour_id);

        if (!is_null($tour->photo)) {
            $tour->photo = url($tour->photo);
        }

        if (!is_null($tour->latitude) && !is_null($tour->longitude)) {
            $GPS = "https://www.google.com/maps/embed/v1/place?key=AIzaSyADdfy-XETavzARnlNC-G3ujuIOxTWU7-w&q=" .
                (string) $tour->latitude . "," . (string) $tour->longitude .
                "&zoom=18&language=zh-tw";
        }

        $comment_list = $tour->comments()->paginate(4);

        $binding = [
            'tour' => $tour,
            'gps' => $GPS,
            'comment_list' => $comment_list,
        ];

        return view('tour.detail-information', $binding);
    }

    public function searchTour()
    {
        $filterRules = array();
        $tours = array();
        $tour_list = array();
        $selectedOptions = array();
        $input = request()->all();

        //initial query
        if (isset($input['search'])) {
            array_push($filterRules,  ['title', 'like', ['%' . $input['search'] . '%']]);
            $tours = $this->query($filterRules)->get();
            $page = ['search' => $input['search']];
            $initialOptions = [
                'country' => $tours->map->only('country')->unique()->flatten(),
                'city' => $tours->map->only('city')->unique()->flatten(),
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];

        } elseif (isset($input['country'])) {
            array_push($filterRules,  ['country', '=', $input['country']]);
            $tours = $this->query($filterRules)->get();
            $page = ['country' => $input['country']];
            $initialOptions = [
                'city' => $tours->map->only('city')->unique()->flatten(),
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];

        } else {
            array_push($filterRules,  ['city', '=', $input['city']]);
            $tours = $this->query($filterRules)->get();
            $page = ['city' => $input['city'], 'country' => $tours[0]->country];
            $initialOptions = [
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];

        }


        //query by selected options
        if (isset($input['m_country']))
        {
            $selectedOptions = array_merge($selectedOptions, ["m_country" => $input['m_country']]);
            array_push($filterRules,  ['country', 'in', $input['m_country']]);
        }

        if (isset($input['m_city']))
        {
            $selectedOptions = array_merge($selectedOptions, ["m_city" => $input['m_city']]);
            array_push($filterRules,  ['city', 'in', $input['m_city']]);
        }

        if (isset($input['price']))
        {
            $selectedOptions = array_merge($selectedOptions, ["price" => $input['price']]);
            array_push($filterRules,  ['price', 'between', explode(',', $input['price'])]);
        }


        if (isset($input['sort'])) {

            $sort = $input['sort'];

            if ($input['sort'] != "default") {
                $tour_list = $this->query($filterRules, 'price', explode('_', $input['sort'])[1])->paginate(8);
            }
            else
            {
                $tour_list = $this->query($filterRules)->paginate(8);
            }
        }

        $binding = [
            'tour_list'=> $tour_list,
            'page' => $page,
            'tour_count' => count($tour_list),
            'sort' => $sort,
            'selected_options' => $selectedOptions,
            'initial_options' => $initialOptions
        ];

        return view('tour.tours', $binding);
    }


    #private methods
    private function query($rules, $sort_column = null, $sort_key = null)
    {
        $query = new TourService();

        return $query->queryTours($rules, $sort_column, $sort_key);
    }
    #end

}
