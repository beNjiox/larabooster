<!-- template color_item -->
  <div style='display:none;' id='color_item_tmpl'>
    <div class='color_code'>
      _CODE_
    </div>
    <div class='color_box' style='background:_CODE_'>
    </div>
    <span class='delete_color' data-color='_CODE_' data-context='{{strtolower($storage_name_sm)}}'>
      <i class='fa fa-times remove_color'></i>
    </span>
  </div>
<!-- template color_item -->

<div class="col-lg-4">
    <div class="panel panel-default">
          <div class="panel-heading">
                <h3 class="panel-title">{{ $storage_name_lg }}</h3>
          </div>
          <div class="panel-body">
                <div class="list-group">
                    <h4 class="list-group-item-heading"></h4>
                    <div class="alert alert-info alert_{{strtolower($storage_name_sm)}} @if (!empty($colors)) no_display @endif">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops</strong> Nothing in the {{$storage_name_lg}}
                    </div>
                    <div class='list_{{strtolower($storage_name_sm)}}'>
                      @foreach ($colors as $c)
                      <div>
                        <div class='color_code'>
                          {{ $c }}
                        </div>
                        <div class='color_box' style="background-color:{{$c}};">
                        </div>
                        <span class='delete_color' data-color='{{$c}}' data-context='{{strtolower($storage_name_sm)}}'>
                          <i class='fa fa-times remove_color'></i>
                        </span>
                      </div>
                      @endforeach
                    </div>
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