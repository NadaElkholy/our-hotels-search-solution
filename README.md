Ourhotels - Hotel Search Solution
===

## Workflow
The api route we created calls the function HotelSearchController@search which validates the get request params and returns a Laravel Resource we encode as json ready for use.

The search function uses service provider which has a function in turn that collects and concatinates results of all available providers from our config file "hotels.config".

Providers are integrated from HotelProvider which has interface functions to add to all of our future providers.

## Testing
> Note: City Code is in IATA code (AUH). You can use the following url to find out the city code you need: 
(https://www.nationsonline.org/oneworld/IATA_Codes/airport_code_a.htm)

```
http://localhost:8000/api/search?from_date=2020-10-1&to_date=2020-10-31&city=CAI&adults_number=2
```

## Challenge Details
OurHotels is a hotel search solution that looks into many providers and displays results from all the available hotels, for now, we are aggregate from two providers: BestHotels and TopHotel.

Implement OurHotels service that should return results from both providers (BestHotels and TopHotel), the result should be a JSON response with a valid HTTP status code of all available hotels ordered by hotel rate.



