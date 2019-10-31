<?php

namespace App\Http\Controllers;

use App\Entities\Tour;
use App\Service\TourService;

class TravelController extends Controller
{

    /**
     * Get tour detail information page
     *
     * @param int $tour_id
     * @return View
     */
    public function tourPage($tour_id)
    {
        $tour = Tour::findOrFail($tour_id);

        if (!is_null($tour->photo)) {
            $tour->photo = url($tour->photo);
        }

        if (!is_null($tour->latitude) && !is_null($tour->longitude)) {
            $map = "https://www.google.com/maps/embed/v1/place?".
                "key=".env('GOOGLE_MAP_KEY').
                "&q=".$tour->city.
                "&center=".(string) $tour->latitude . "," . (string) $tour->longitude .
                "&zoom=15&language=zh-tw";
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

    /**
     * Show tours on the page by searching.
     *
     * @return View
     */
    public function searchTour()
    {
        $filter_rules = array();
        $tours = array();
        $tour_list = array();
        $selected_options = array();
        $input = request()->all();

        #initial query
        if (isset($input['search'])) {
            array_push($filter_rules, ['title', 'like', ['%' . $input['search'] . '%']]);
            $tours = $this->query($filter_rules)->get();
            $page = ['search' => $input['search']];
            $initial_options = [
                'country' => $tours->map->only('country')->unique()->flatten(),
                'city' => $tours->map->only('city')->unique()->flatten(),
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];
        } elseif (isset($input['country'])) {
            array_push($filter_rules, ['country', '=', $input['country']]);
            $tours = $this->query($filter_rules)->get();
            $page = ['country' => $input['country']];
            $initial_options = [
                'city' => $tours->map->only('city')->unique()->flatten(),
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];
        } else {
            array_push($filter_rules, ['city', '=', $input['city']]);
            $tours = $this->query($filter_rules)->get();
            $page = ['city' => $input['city'], 'country' => $tours[0]->country];
            $initial_options = [
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];
        }
        #end

        #query by selected options
        if (isset($input['m_country'])) {
            $selected_options = array_merge($selected_options, ["m_country" => $input['m_country']]);
            array_push($filter_rules, ['country', 'in', $input['m_country']]);
        }

        if (isset($input['m_city'])) {
            $selected_options = array_merge($selected_options, ["m_city" => $input['m_city']]);
            array_push($filter_rules, ['city', 'in', $input['m_city']]);
        }

        if (isset($input['price'])) {
            $selected_options = array_merge($selected_options, ["price" => $input['price']]);
            array_push($filter_rules, ['price', 'between', explode(',', $input['price'])]);
        }
        #end

        #sort
        if (isset($input['sort'])) {
            $sort = $input['sort'];

            if ($input['sort'] != "default") {
                $tour_list = $this->query($filter_rules, 'price', explode('_', $input['sort'])[1])->paginate(8);
            } else {
                $tour_list = $this->query($filter_rules)->paginate(8);
            }
        }
        #end

        $binding = [
            'tour_list'=> $tour_list,
            'page' => $page,
            'sort' => $sort,
            'selected_options' => $selected_options,
            'initial_options' => $initial_options,
            'title' => '經典行程'
        ];

        return view('tour.tours', $binding);
    }


    #private methods

    /**
     * Query tours.
     *
     * @param string $rules
     * @param string|null $sort_column
     * @param string|null $sort_key
     * @return array
     */
    private function query($rules, $sort_column = null, $sort_key = null)
    {
        $query = new TourService();
        return $query->queryTours($rules, $sort_column, $sort_key);
    }

    #end
}
