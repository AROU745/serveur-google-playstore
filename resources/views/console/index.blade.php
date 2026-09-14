@extends('layouts.app')

@section('title', 'Console applications — Google Play Server Service')

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Console applications</h1>
        <p>Accédez aux applications mobiles liées à votre espace</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            @forelse($apps as $app)
                <div class="col-md-6 col-lg-4">
                    <div class="console-app-card h-100">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <img src="{{ asset($app['icon']) }}"
                                 alt="Logo {{ $app['name'] }}"
                                 class="console-app-card-logo"
                                 width="64"
                                 height="64">
                            <div>
                                <h2 class="h5 mb-1">{{ $app['name'] }}</h2>
                                @if(!empty($app['developer']))
                                    <p class="small text-secondary mb-0">{{ $app['developer'] }}</p>
                                @endif
                                @if(!empty($app['package']))
                                    <code class="small">{{ $app['package'] }}</code>
                                @endif
                            </div>
                        </div>
                        @if(!empty($app['description']))
                            <p class="text-secondary small mb-3">{{ $app['description'] }}</p>
                        @endif
                        <a href="{{ $app['url'] }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn btn-accent w-100 d-inline-flex align-items-center justify-content-center gap-2">
                            <img src="{{ asset($app['icon']) }}"
                                 alt=""
                                 class="console-app-logo"
                                 width="22"
                                 height="22">
                            Ouvrir sur Google Play
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="form-card text-center">
                        <p class="mb-0 text-secondary">Aucune application pour le moment.</p>
                    </div>
                </div>
            @endforelse
        </div>
        <p class="small text-secondary mt-4 mb-0">
            Service indépendant —  affilié à Google LLC. Les marques et logos appartiennent à leurs propriétaires respectifs.
        </p>
    </div>
</section>
@endsection
