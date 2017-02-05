<div class="form-group">
    {{ Form::label($name, $label, ['class' => 'control-label' . (in_array('required', $attributes) ? ' required' : '')]) }}
    {{ Form::text($name, $value, array_merge(['class' => 'form-control'], $attributes)) }}
</div>
