<?php

namespace App\Providers;

interface HotelProvider
{
    /**
     * @param string $from
     * @param string $to
     * @param string $cityIataCode
     * @param int $numberOfAdults
     * @return \Illuminate\Support\Collection
     */
    public function findMany(string $from, string $to, string $cityIataCode, int $numberOfAdults);

    /**
     * @param string $fromDate
     * @param string $toDate
     * @param string $city
     * @param int $numberOfAdults
     * @return array
     */
    public function getHotels(string $fromDate, string $toDate, string $city, int $numberOfAdults): array;
}
