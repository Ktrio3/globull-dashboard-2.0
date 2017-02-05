<div class="form-group">
    {{ Form::label($name, null, ['class' => 'control-label' . (in_array('required', $attributes) ? ' required' : '')]) }}
    {{ Form::number($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
</div>
