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
        $filterRules = array();
        $tours = array();
        $tour_list = array();
        $selectedOptions = array();
        $input = request()->all();

        #initial query
        if (isset($input['search'])) {
            array_push($filterRules, ['title', 'like', ['%' . $input['search'] . '%']]);
            $tours = $this->query($filterRules)->get();
            $page = ['search' => $input['search']];
            $initialOptions = [
                'country' => $tours->map->only('country')->unique()->flatten(),
                'city' => $tours->map->only('city')->unique()->flatten(),
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];
        } elseif (isset($input['country'])) {
            array_push($filterRules, ['country', '=', $input['country']]);
            $tours = $this->query($filterRules)->get();
            $page = ['country' => $input['country']];
            $initialOptions = [
                'city' => $tours->map->only('city')->unique()->flatten(),
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];
        } else {
            array_push($filterRules, ['city', '=', $input['city']]);
            $tours = $this->query($filterRules)->get();
            $page = ['city' => $input['city'], 'country' => $tours[0]->country];
            $initialOptions = [
                'price' => ['min' => $tours->min('price'), 'max' => $tours->max('price')]
            ];
        }
        #end

        #query by selected options
        if (isset($input['m_country'])) {
            $selectedOptions = array_merge($selectedOptions, ["m_country" => $input['m_country']]);
            array_push($filterRules, ['country', 'in', $input['m_country']]);
        }

        if (isset($input['m_city'])) {
            $selectedOptions = array_merge($selectedOptions, ["m_city" => $input['m_city']]);
            array_push($filterRules, ['city', 'in', $input['m_city']]);
        }

        if (isset($input['price'])) {
            $selectedOptions = array_merge($selectedOptions, ["price" => $input['price']]);
            array_push($filterRules, ['price', 'between', explode(',', $input['price'])]);
        }
        #end

        #sort
        if (isset($input['sort'])) {
            $sort = $input['sort'];

            if ($input['sort'] != "default") {
                $tour_list = $this->query($filterRules, 'price', explode('_', $input['sort'])[1])->paginate(8);
            } else {
                $tour_list = $this->query($filterRules)->paginate(8);
            }
        }
        #end

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
