<?php

namespace App\Http\Controllers\User;


use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\SelectedPropertyResource;

class SelectedPropertyController extends Controller
{
    public function getLatestProperties()
    {
        $propertyTables = [
            'houses',
            'flats',
            'lands',
            'villas',
            'offices',
            'shops',
            'chalets',
            'clinics',
        ];

        $propertiesByType = [];

        foreach ($propertyTables as $table) {
            $properties = DB::table($table)
                ->join('properties', "{$table}.property_id", '=', 'properties.id')
                ->where("{$table}.status", 'active')
                ->where("{$table}.sale", 'notSold')
                // ->where("{$table}.mainImage")
                ->select("{$table}.*", 'properties.status as property_name', "{$table}.mainImage")
                ->orderBy("{$table}.created_at", 'desc')
                ->take(6)
                ->get();

            if ($properties->isEmpty()) {
                $propertiesByType[$table] = [];
                continue;
            }

            $propertiesByType[$table] = SelectedPropertyResource::collection($properties);
        }

        return response()->json($propertiesByType); // الـreturn هنا برة الـloop
    }
}
