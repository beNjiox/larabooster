@extends('master')

@section('content')

<section class='content' style='margin-top:25px;'>    

    <div class="container">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">MySQL storage</h3>
                  </div>
                  <div class="panel-body">
                        <div class="list-group">
                            <h4 class="list-group-item-heading"></h4>
                            @if (empty($mysql_colors))
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Oops</strong> Nothing in the Redis Storage
                                </div>
                            @else                           
                              @foreach ($mysql_colors as $c)
                              <ul>
                                  <li>
                                      {{ $c['code'] }}
                                      <div style="float:right;width:30px;height:30px;background:{{ $c['code'] }}"></div>
                                  </li>
                              </ul>
                              @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                          <legend>Add color to MySQL</legend>
                        </div>
                  
                          <div class="form-group">
                            <input type="text" name="color" placeholder='eg. #424242'>
                            <input type="submit" value='submit' name="submit" id="" class='btn btn-primary btn-sm'>
                          </div>              
                  </div>
            </div>
        </div> 
    
        <!-- - MEMCACHE - -->

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">Memcache storage</h3>
                  </div>
                  <div class="panel-body">
                        <div class="list-group">
                            <h4 class="list-group-item-heading"></h4>
                            @if (empty($memcache_colors))
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Oops</strong> Nothing in the memcache Storage
                                </div>
                            @else 
                                @foreach ($memcache_colors as $c)
                                <ul>
                                    <li>
                                        {{ $c }}
                                        <div style="float:right;width:30px;height:30px;background:{{$c}}">
                                            
                                        </div>
                                    </li>
                                </ul>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                          <legend>Add color to MemCache</legend>
                        </div>
                  
                          <div class="form-group">
                            <input type="text" name="color" placeholder='eg. #424242'>
                            <input type="submit" value='submit' name="submit" id="" class='btn btn-primary btn-sm'>
                          </div>              

                  </div>
            </div>
        </div>    


        <!-- - REDIS - -->

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">Redis storage</h3>
                  </div>
                  <div class="panel-body">
                        <div class="list-group">
                            <h4 class="list-group-item-heading"></h4>
                            @if (empty($redis_colors))
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Oops</strong> Nothing in the Redis Storage
                                </div>
                            @else 
                                @foreach ($redis_colors as $c)
                                <ul>
                                    <li>
                                        {{ $c }}
                                        <div style="float:right;width:30px;height:30px;background:{{$c}}">
                                            
                                        </div>
                                    </li>
                                </ul>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group">
                          <legend>Add color to Redis</legend>
                        </div>
                  
                          <div class="form-group">
                            <input type="text" name="color" placeholder='eg. #424242'>
                            <input type="submit" value='submit' name="submit" id="" class='btn btn-primary btn-sm'>
                          </div>              

                  </div>
            </div>
        </div>        

    </div>

    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2> About </h2>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">Backend technologies</h3>
                  </div>
                  <div class="panel-body">
                        <div class="list-group">                            
                            <ul>
                                <li>Vagrant using Precise32Box (Linux)</li>
                                <li>Laravel & PHP 5.5</li>
                                <li>Redis</li>
                                <li>Memcache</li>
                                <li>MySQL</li>
                            </ul>
                        </div>
                  </div>
            </div>
        </div>   
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                  <div class="panel-heading">
                        <h3 class="panel-title">FrontEnd technologies</h3>
                  </div>
                  <div class="panel-body">
                        <div class="list-group">                            
                            <ul>
                                <li>Bootstrap 3 + Bootswatch flatly</li>
                                <li>AngularJS & Restangular</li>
                            </ul>
                        </div>
                  </div>
            </div>
        </div>        

    </div>

</section>

@stop