@extends('layouts.admin')

@section('title', 'Clients')
@section('heading', 'Clients')

@section('content')
<form class="row g-2 mb-3" method="GET">
    <div class="col-md-6">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Rechercher un client…">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filtrer</button>
    </div>
</form>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Entreprise</th>
                    <th>Email</th>
                    <th>Pays</th>
                    <th>Commandes</th>
                    <th>Inscrit le</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->company_name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->country }}</td>
                        <td>{{ $customer->orders_count }}</td>
                        <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary py-4">Aucun client</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $customers->links() }}</div>
@endsection
