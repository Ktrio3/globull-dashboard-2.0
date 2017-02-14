<div class="form-group">
    {{ Form::label($name, $label, ['class' => 'control-label' . (in_array('required', $attributes) ? ' required' : '')]) }}
    {{ Form::select($name, $value, $default, array_merge(['class' => 'form-control', 'data-placeholder' => $placeholder], $attributes)) }}
</div>
