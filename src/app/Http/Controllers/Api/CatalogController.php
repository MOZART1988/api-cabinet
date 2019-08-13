<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Country;
use App\Direction;
use App\Http\Resources\CityResource;
use App\Http\Resources\CountryResource;
use App\Http\Resources\DirectionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CatalogController extends Controller
{

    public function directions(Request $request)
    {
        $query = Direction::query();

        if ($request->has('code')) {
            $query->where('code', '=', $request->get('code'));
        }

        if ($request->has('avia')) {
            $query->where('avia', '=', $request->get('avia'));
        }

        if ($request->has('international')) {
            $query->where('international', '=', $request->get('international'));
        }

        if ($request->has('corridor')) {
            $query->where('corridor', '=', $request->get('corridor'));
        }

        if ($request->has('price_kg')) {
            $query->where('price_kg', '=', $request->get('price_kg'));
        }

        if ($request->has('delivery_time')) {
            $query->where('delivery_time', '=', $request->get('delivery_time'));
        }

        if ($request->has('direction')) {
            $query->where('direction', 'like', $request->get('direction') . '%');
        }

        return DirectionResource::collection($query->paginate());
    }

    public function countries(Request $request)
    {
        $query = Country::query();

        if ($request->has('code')) {
            $query->where('code', '=', $request->get('code'));
        }

        if ($request->has('name')) {
            $query->where('name', 'like', $request->get('name') . '%');
        }

        if ($request->has('name_full')) {
            $query->where('name_full', 'like', $request->get('name_full') . '$');
        }

        if ($request->has('CodAlpha2')) {
            $query->where('CodAlpha2', 'like', $request->get('CodAlpha2') . '%');
        }

        if ($request->has('CodAlpha3')) {
            $query->where('CodAlpha3', 'like', $request->get('CodAlpha3') . '%');
        }

        return CountryResource::collection($query->paginate());
    }

    public function cities(Request $request)
    {
        $query = City::query();

        if ($request->has('code')) {
            $query->where('code', '=', $request->get('code'));
        }

        if ($request->has('name')) {
            $query->where('name', 'like', $request->get('name') . '%');
        }

        if ($request->has('city_code')) {
            $query->where('city_code', 'like', $request->get('city_code'). '%');
        }

        if ($request->has('region')) {
            $query->where('region', 'like', $request->get('region') . '%');
        }

        return CityResource::collection($query->paginate());

    }
}
