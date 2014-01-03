<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">{{ $storage_name_lg }}</h3>
          </div>
          <div class="panel-body">
                <div class="list-group">
                    <h4 class="list-group-item-heading"></h4>
                    @if (empty($colors))
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops</strong> Nothing in the {{$storage_name_lg}}
                        </div>
                    @else                           
                      <div class='list_{{strtolower($storage_name_sm)}}'>
                        @foreach ($colors as $c)
                        <div>
                          <div class='color_code'>
                            {{ $c['code'] }}
                          </div>
                          <div class='color_box' style="background-color:{{$c['code']}};">
                          </div>
                        </div>
                        @endforeach
                      </div>
                    @endif
                </div>

                <div class="form-group">
                  <legend>Add color to {{ $storage_name_sm }}</legend>
                </div>
          
                  <div class="form-group">
                    <input type="text"
                           class='add_color_input_{{strtolower($storage_name_sm)}}'
                           name="color"
                           placeholder='eg. #424242'>

                    <input type="submit"
                           value='submit'
                           name="submit"
                           data-context='{{strtolower($storage_name_sm)}}'
                           class='btn btn-primary btn-sm add_color'>
                  </div>              
          </div>
    </div>
</div> 