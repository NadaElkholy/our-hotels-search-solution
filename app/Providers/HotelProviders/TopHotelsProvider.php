<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Hotel;
use App\Providers\HotelProvider;

class TopHotelsProvider implements HotelProvider
{
    const PROVIDER_NAME = 'TopHotels';

    /**
     * Top Hotels endpoint
     *
     * @var string
     */
    protected $hotelApiEndpoint;

    /**
     * BestHotelProvider constructor.
     */
    public function __construct()
    {
        // $this->hotelApiEndpoint = 'https://top-hotels.com/searchApi';
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $cityIataCode
     * @param int $numberOfAdults
     * @return array
     */
    public function findMany(string $from, string $to, string $cityIataCode, int $numberOfAdults): array
    {
        $hotelsApiResult = $this->getHotels($from, $to, $cityIataCode, $numberOfAdults);

        foreach ($hotelsApiResult as $hotelAttributes) {
            $hotels[] = $this->createHotelInstance($hotelAttributes);
        }

        return $hotels ?? [];
    }

    /**
     * Mimic the api http request.
     *
     * @param string $fromDate
     * @param string $toDate
     * @param string $city
     * @param int $numberOfAdults
     * @return array
     */
    public function getHotels(string $fromDate, string $toDate, string $city, int $numberOfAdults): array
    {

        # Sending Http Request
        // $response = Http::withHeaders([
        //     'Accept' => 'application/json',
        // ])->get($this->hotelApiEndpoint, [
        //     'from' => Carbon::parse($fromDate)->toIso8601ZuluString(),
        //     'To' => Carbon::parse($toDate)->toIso8601ZuluString(),
        //     'city' => $city,
        //     'adultsCount' => $numberOfAdults,
        // ]);

        // return json_decode($response);
        //Read from Json file as replacement for request
        $jsonString = file_get_contents(base_path('resources/hotelData/TopHotel.json'));
        $data = json_decode($jsonString, true);
        // dd($data);
        return $data;

        return $this->getHotelsData();
    }

    /**
     * Create an object from Hotel.
     *
     * @param $hotelAttributes
     * @return Hotel
     */
    public function createHotelInstance($hotelAttributes): Hotel
    {
        $hotel = (new Hotel)
            ->setProvider(static::PROVIDER_NAME)
            ->setName($hotelAttributes['hotelName'])
            ->setFare($hotelAttributes['price'])
            ->setRate(strlen($hotelAttributes['rate']))
            ->setAmenities($hotelAttributes['amenities']);

        if (isset($hotelAttributes['discount'])) {
            $hotel->setDiscount($hotelAttributes['discount']);
        }

        return $hotel;
    }
}
