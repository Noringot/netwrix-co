<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Partner;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnersSearch extends Controller
{
  public function getAllCountries() {
    $countries = Country::all(['name', 'short_name']);

    for ($i=0;$i < count($countries);$i++) {

      $countries[$i]->label = $countries[$i]->name;
      $countries[$i]->value = $countries[$i]->short_name;

      unset($countries[$i]->name);
      unset($countries[$i]->short_name);
    }
    return $countries;
  }

  public function getAllStates() {
    $all_states = State::all();
    $states = [];

    for ($i = 0; $i < count($all_states); $i++) {

      if ($all_states[$i]->short_name == 'nostate') continue;
      $country_id = $all_states[$i]->country_id;
      $country = Country::where('country_id', $country_id)->first();
      $states[$country->short_name][] = ['label' => $all_states[$i]->name, 'value' => $all_states[$i]->short_name];

    }
    return $states;
  }

  public function getAllPartners() {
    $partners = Partner::all();
    for ($i = 0; $i < count($partners); $i++) {
      $partners[$i]->countries_covered = json_decode($partners[$i]->countries_covered);
      $partners[$i]->states_covered = json_decode($partners[$i]->states_covered);

      $partners[$i]['searchFilter'] = false;
      $partners[$i]['partnerTypeFilter'] = false;
      $partners[$i]['countryFilter'] = false;
      $partners[$i]['stateFilter'] = false;
    }
    return $partners;
  }
}
