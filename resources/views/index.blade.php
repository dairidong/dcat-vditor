<div class="{{$viewClass['form-group']}}">

  <label class="{{$viewClass['label']}} control-label">{!! $label !!}</label>

  <div class="{{$viewClass['field']}}">

    @include('admin::form.error')

    <div class="{{$class}}" {!! $attributes !!}></div>

    @include('admin::form.help-block')

    <input type="hidden" name="{{$name}}" value="{!! $value !!}">
  </div>
</div>


<script require="@vditor" init="{!! $selector !!}">
    let options = {!! $options !!};

    options.input = function (md) {
        $('input[name={{$name}}]').val(md)
    };

    let vditor = new Vditor(id, options);

    @if(!$enable)
    vditor.disabled()
  @endif
</script>
