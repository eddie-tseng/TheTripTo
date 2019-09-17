<?php

namespace App\Http\Controllers;
use App\Entities\Tour;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    // 首頁
    public function home()
    {
        if(session()->has('id')){
            $tours = Tour::popular()->get();
        }
        else
        {
            $tours = Tour::popular()->get();
        }

        $avg_stars= array();
        $tour_bookings = array();
        $sum_stars = 0;

        // foreach($tours as $tour){
        //     if(!$tour->orders->isEmpty())
        //     {
        //         $count = $tour->orders->count();
        //         foreach($tour->orders as $booking){
        //             $sum_stars += $booking->comment->rating;
        //         }
        //         array_push($avg_stars,  $sum_stars/$count);
        //         array_push($tour_bookings,  $count);
        //     }
        //     else {
        //         array_push($avg_stars, 0);
        //         array_push($tour_bookings, 0);
        //     }
        // }

        $binding = [
            'tours'=> $tours,
            // 'avg_stars'=> $avg_stars,
            // 'orders' => $tour_bookings
        ];

        return view('tour.recommended-trips', $binding);
    }

    public function searchTour()
    {
        $names = array();
        $ids = array();
        $tours = array();
        $builder = Tour::where('status', 'r');
        $input = request()->all();

        if($input['search'])
        {
            $tours = $builder
            ->select('id', 'title')
            ->where('title','like', '%'.$input['search'].'%')
            ->take(3)
            ->get();
        }

        if($tours)
        {
            foreach ($tours as $tour) {
                array_push($ids, $tour->id);
                array_push($names, $tour->title);
            }
        }


        return response()
        ->json([
            'ids' => $ids,
            'names' => $names
            ]);
    }


}
