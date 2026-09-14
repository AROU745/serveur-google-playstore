@extends('layouts.app')

@section('title', 'Contact — Google Play Server Service')

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Contact</h1>
        <p>Une question sur l'offre ou votre commande ? Écrivez-nous.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="form-card">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nom *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Sujet *</label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message *</label>
                                <textarea name="message" rows="5" class="form-control" required>{{ old('message') }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-accent mt-4">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
