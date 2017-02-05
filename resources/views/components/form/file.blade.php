<div class="form-group">
    {{ Form::label($name, null, ['class' => 'control-label' . (in_array('required', $attributes) ? ' required' : '')]) }}
    {{ Form::file($name, $attributes) }}
</div>
