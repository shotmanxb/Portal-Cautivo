<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use View;
use DB;

use Illuminate\Http\Request;

class TestController extends Controller {

    public function index() {

        $data1 =  \DB::table('metropolitan')
          ->select(array('name', \DB::raw('COUNT(*) as progress')))
          ->orderBy('progress', 'DESC')
          ->groupBy('name')
          ->take(5)
          ->get();

        $data1 = collect($data1)->map(function($x){ return (array) $x; })->toArray(); 

        $data['tasks'] = [
                [
                        'name' => 'Design New Dashboard',
                        'progress' => '87',
                        'color' => 'danger'
                ],
                [
                        'name' => 'Create Home Page',
                        'progress' => '76',
                        'color' => 'warning'
                ],
                [
                        'name' => 'Some Other Task',
                        'progress' => '32',
                        'color' => 'success'
                ],
                [
                        'name' => 'Start Building Website',
                        'progress' => '56',
                        'color' => 'info'
                ],
                [
                        'name' => 'Develop an Awesome Algorithm',
                        'progress' => '10',
                        'color' => 'success'
                ]
        ];
        return view('test')->with($data);
    }

public function table(){
        $data =  \DB::table('metropolitan')
          ->select(array('name', \DB::raw('COUNT(*) as count')))
          ->orderBy('count', 'DESC')
          ->groupBy('name')
          ->take(5)
          ->get();

       return $data = collect($data)->map(function($x){ return (array) $x; })->toArray(); 
    }

    public function chartjs()
{
    $viewer = \DB::table('metropolitan')
        ->select(\DB::raw("SUM(name) as count"))
        ->orderBy("created_at")
        ->groupBy(\DB::raw("created_at"))
        ->get()->toArray();
    $viewer = array_column($viewer, 'count');
    
    $click = \DB::table('metropolitan')
        ->select(\DB::raw("SUM(name) as count"))
        ->orderBy("created_at")
        ->groupBy(\DB::raw("created_at"))
        ->get()->toArray();
    $click = array_column($click, 'count');
    
    return view('chartjs')
            ->with('viewer',json_encode($viewer,JSON_NUMERIC_CHECK))
            ->with('click',json_encode($click,JSON_NUMERIC_CHECK));
}
}