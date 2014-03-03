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

</section>

@stop