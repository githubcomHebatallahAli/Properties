<?php

namespace App\Http\Controllers\User;


use App\Models\Broker;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Broker\BrokerProfileResource;


class BrokerController extends Controller
{
    // public function showAll()
    // {

    //     $Brokers = Broker::get();
    //     return response()->json([
    //         'data' => $Brokers->map(function ($Broker) {
    //             return [
    //                 'id' => $Broker->id,
    //                 'name' => $Broker->name,
    //                 'photo' => $Broker->photo,
    //                 'governorate' => $Broker->governorate,
    //                 'address' => $Broker-> address,
    //                 'rating' => $Broker->ratings->avg('rating') ?? 0
    //             ];
    //         }),
    //         'message' => "Show All Brokers Successfully."
    //     ]);
    // }

    public function showAll()
    {

        $Brokers = Broker::with(['ratings' => function ($query) {
            $query->select('broker_id', DB::raw('AVG(rating) as average_rating'))
                  ->groupBy('broker_id');
        }])->get();

        return response()->json([
            'data' => $Brokers->map(function ($Broker) {
                return [
                    'id' => $Broker->id,
                    'name' => $Broker->name,
                    'photo' => $Broker->photo,
                    'governorate' => $Broker->governorate,
                    'address' => $Broker->address,
                    'rating' => number_format(round($Broker->ratings->first()->average_rating ?? 0, 1), 1) // استخدام المتوسط المحسوب
                ];
            }),
            'message' => "Show All Brokers Successfully."
        ]);
    }

    public function editBrokerProfile($id)
    {

        $broker = Broker::with([
            'ratings.user',
            'flats.property', 'villas.property', 'shops.property', 'lands.property',
            'offices.property', 'chalets.property', 'clinics.property', 'houses.property' // جميع أنواع العقارات مع properties
        ])->findOrFail($id);

        $avgRating = $broker->ratings->avg('rating');

        $properties = collect([])
            ->merge($broker->flats->map(function ($flat) {
                return [
                    'name' => $flat->property->status,
                    'governorate' => $flat->governorate,
                    'mainImage' => $flat->mainImage,
                    'totalPrice' => $flat->totalPrice,
                ];
            }))
            ->merge($broker->villas->map(function ($villa) {
                return [
                    'name' => $villa->property->status,
                    'governorate' => $villa->governorate,
                    'mainImage' => $villa->mainImage,
                    'totalPrice' => $villa->totalPrice,
                ];
            }))
            ->merge($broker->shops->map(function ($shop) {
                return [
                    'name' => $shop->property->status,
                    'governorate' => $shop->governorate,
                    'mainImage' => $shop->mainImage,
                    'totalPrice' => $shop->totalPrice,
                ];
            }))
            ->merge($broker->lands->map(function ($land) {
                return [
                    'name' => $land->property->status,
                    'governorate' => $land->governorate,
                    'mainImage' => $land->mainImage,
                    'totalPrice' => $land->totalPrice,
                ];
            }))
            ->merge($broker->offices->map(function ($office) {
                return [
                    'name' => $office->property->status,
                    'governorate' => $office->governorate,
                    'mainImage' => $office->mainImage,
                    'totalPrice' => $office->totalPrice,
                ];
            }))
            ->merge($broker->chalets->map(function ($chalet) {
                return [
                    'name' => $chalet->property->status,
                    'governorate' => $chalet->governorate,
                    'mainImage' => $chalet->mainImage,
                    'totalPrice' => $chalet->totalPrice,
                ];
            }))
            ->merge($broker->clinics->map(function ($clinic) {
                return [
                    'name' => $clinic->property->status,
                    'governorate' => $clinic->governorate,
                    'mainImage' => $clinic->mainImage,
                    'totalPrice' => $clinic->totalPrice,
                ];
            }))
            ->merge($broker->houses->map(function ($house) {
                return [
                    'name' => $house->property->status,
                    'governorate' => $house->governorate,
                    'mainImage' => $house->mainImage,
                    'totalPrice' => $house->totalPrice,
                ];
            }));
            $broker->propertiesCount = $properties->count();
            $broker->save();

        return response()->json([
            'broker' => new BrokerProfileResource($broker),
            'properties' => $properties,
        ]);
    }
}
