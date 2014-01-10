@extends('master')

@section('javascript')
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="js/jquery.maskedinput.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.5/angular.min.js"></script>
    <script src="js/app.js"></script>
@stop

@section('content')

<section ng-app='app' class='content' style='margin-top:25px;'>

    <div class="container" ng-controller="StorageCtrl">
        <storage-panel ng-name='mysql'></storage-panel>
        <storage-panel ng-name='memcache'></storage-panel>
        <storage-panel ng-name='redis'></storage-panel>
    </div>

    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2> Changelog </h2>

            <ul class='list-unstyled'>
                <li><h3> v0.1 </h3></li>
                <ul>
                    <li> First release </li>
                    <li> 3 Storages in place : MySQL , Redis , Memcache </li>
                    <li> Add , Deletions capabilities </li>
                    <li> Vagrant install stable </li>
                </ul>
                <li><h3> v0.2 </h3><li>
                <ul>
                    <li>UI using angularJS</li>
                    <li>Better routing</li>
                </ul>
            </ul>
        </div>
    </div>

</section>

@stop