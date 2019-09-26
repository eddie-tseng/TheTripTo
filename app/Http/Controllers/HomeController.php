<?php

namespace App\Http\Controllers;

use App\Entities\Tour;

class HomeController extends Controller
{
    public function index()
    {
        if (session()->has('id')) {
            $tours = Tour::popular()->get();
        } else {
            $tours = Tour::popular()->get();
        }

        $binding = [
            'tours' => $tours,
            'title' => "首頁"
        ];

        return view('index', $binding);
    }

    public function searchTour()
    {
        $names = array();
        $ids = array();
        $tours = array();
        $builder = Tour::where('status', 'r');
        $input = request()->all();

        if ($input['search']) {
            $tours = $builder
                ->select('id', 'title')
                ->where('title', 'like', '%' . $input['search'] . '%')
                ->take(3)
                ->get();
        }

        if ($tours) {
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
