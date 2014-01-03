@extends('master')

@section('content')

<section class='content' style='margin-top:25px;'>    

    <div class="container">

        {{ View::make('partials.storage_panel', ['colors' => $mysql_colors, 
                                                 'storage_name_lg' =>'MySQL Storage',
                                                 'storage_name_sm' => 'MySQL' ]) }}
        {{ View::make('partials.storage_panel', ['colors' => $memcache_colors, 
                                                 'storage_name_lg' =>'Memcache Storage',
                                                 'storage_name_sm' => 'Memcache' ]) }}
        {{ View::make('partials.storage_panel', ['colors' => $redis_colors, 
                                                 'storage_name_lg' =>'Redis Storage',
                                                 'storage_name_sm' => 'Redis' ]) }}
    
    </div>

    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2> About </h2>
        </div>

        {{ View::make('partials.techno_panel', [ 'title' => "Backend Stack",
                                                 'list' => ["Vagrant using Precise32Box (Linux)", 
                                                            "Laravel & PHP 5.5",
                                                            "Redis",
                                                            "Memcache",
                                                            "MySQL"] ])}}

        {{ View::make('partials.techno_panel', [ 'title' => "Frontend Stack",
                                                 'list' => ["Bootstrap 3 + Bootswatch flatly", 
                                                            "AngularJS & Restangular" ] ]) }}
    </div>

</section>

<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/home.js"></script>

@stop