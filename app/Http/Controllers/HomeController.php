<?php

namespace App\Http\Controllers;

use App\Entities\Tour;

class HomeController extends Controller
{
    /**
     * Get index page.
     *
     * @return View
     */
    public function index()
    {
        if (session()->has('id')) {
            $tours = Tour::popular()->get();
        } else {
            $tours = Tour::popular()->get();
        }

        $binding = [
            'tours' => $tours,
        ];

        return view('index', $binding);
    }

    /**
     * Live search for search-bar
     *
     * @return JsonResponse
     */
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
