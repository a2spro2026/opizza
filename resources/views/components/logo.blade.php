@props(['class' => 'h-9 w-9'])

@php $logo = public_path('images/opizza-logo.png'); $v = file_exists($logo) ? filemtime($logo) : 1; @endphp
<img src="{{ asset('images/opizza-logo.png') }}?v={{ $v }}" alt="Logo Restaurant O'pizza"
     {{ $attributes->merge(['class' => $class . ' object-contain']) }}>
