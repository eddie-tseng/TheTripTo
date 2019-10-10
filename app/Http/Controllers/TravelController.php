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


    //行程頁
    public function tourPage($tour_id)
    {
        $tour = Tour::findOrFail($tour_id);

        if (!is_null($tour->photo)) {
            $tour->photo = url($tour->photo);
        }

        if (!is_null($tour->latitude) && !is_null($tour->longitude)) {
            $map = "https://www.google.com/maps/embed/v1/place?key=AIzaSyADdfy-XETavzARnlNC-G3ujuIOxTWU7-w&q=" .
                (string) $tour->latitude . "," . (string) $tour->longitude .
                "&zoom=18&language=zh-tw";
        }

        $comment_list = $tour->comments()->paginate(4);

        $binding = [
            'tour' => $tour,
            'map' => $map,
            'comment_list' => $comment_list,
            'title' => $tour->title,
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
            'sort' => $sort,
            'selected_options' => $selectedOptions,
            'initial_options' => $initialOptions,
            'title' => '經典行程'
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
