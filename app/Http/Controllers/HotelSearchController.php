<?php

namespace App\Http\Controllers;

use App\Services\HotelService;
use App\Http\Resources\HotelResource;
use App\Http\Requests\SearchRequest;
use App\Http\Controllers\Controller;

class HotelSearchController extends Controller
{
    /**
     * @var OurHotelsService
     */
    private $hotelsService;

    /**
     * HotelsSearchController constructor.
     *
     * @param OurHotelsService $hotelsService
     */
    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(SearchRequest $request)
    {
        $hotelsResult = HotelResource::collection($this->hotelService->search(
            $request->input('from_date'),
            $request->input('to_date'),
            $request->input('city'),
            $request->input('adults_number')
        ));

        if(empty($hotelsResult)){
            return responseJson(1, 200, 'No Results were Found.');
        }

        return responseJson(1, 200, 'Search Results Found.', $hotelsResult);
    }
}
