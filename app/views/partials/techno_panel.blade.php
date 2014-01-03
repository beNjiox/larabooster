<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">{{ $title }}</h3>
          </div>
          <div class="panel-body">
                <div class="list-group">                            
                    <ul>
                        @foreach ($list as $li)
                        <li>{{ $li }}</li>
                        @endforeach
                    </ul>
                </div>
          </div>
    </div>
</div>   

  