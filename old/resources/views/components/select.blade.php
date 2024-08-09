@props(['options' => [], 'selected' => ''])

<select {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    <option value=""></option>
    @if(is_array($options))
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @if($selected == $key) selected @endif >{{ $option }}</option>
        @endforeach
    @endif
</select>