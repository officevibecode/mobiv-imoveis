@props([
    'title' => 'MOBIV Imóveis',
    'description' => 'Encontre o imóvel perfeito em Portugal. Apartamentos, moradias e terrenos.',
    'canonical' => null,
    'noindex' => false,
    'image' => null,
    'type' => 'website'
])

@php
    $fullTitle = $title === 'MOBIV Imóveis' ? $title : $title . ' | MOBIV Imóveis';
    $canonicalUrl = $canonical ?? url()->current();
    $ogImage = $image ?? asset('images/og-default.jpg');
@endphp

<title>{{ $fullTitle }}</title>
<meta name="description" content="{{ $description }}">

<!-- Canonical -->
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Robots -->
@if($noindex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow">
@endif

<!-- Open Graph -->
<meta property="og:title" content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="MOBIV Imóveis">
<meta property="og:locale" content="pt_PT">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<!-- Preconnect for performance -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- Inter font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
