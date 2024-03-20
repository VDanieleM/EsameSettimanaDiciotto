<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Amministrazione') }}
        </h2>
    </x-slot>

    <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome Utente</th>
                <th scope="col">Corso</th>
                <th scope="col">Data Richiesta</th>
                <th scope="col">Stato</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reservations as $reservation)
            <tr>
                <th scope="row">{{ $reservation->id }}</th>
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->course->name }}</td>
                <td>{{ $reservation->created_at }}</td>
                <td>
                    @if($reservation->is_accepted === null)
                        <span class="badge badge-warning">In attesa di conferma</span>
                    @elseif($reservation->is_accepted == true)
                        <span class="badge badge-success">Confermato</span>
                    @else
                        <span class="badge badge-danger">Rifiutato</span>
                    @endif
                </td>
                <td>
                        <form action="{{ route('reservations.accept', $reservation->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Conferma</button>
                        </form>
                        <form action="{{ route('reservations.reject', $reservation->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Rifiuta</button>
                        </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


</x-app-layout>