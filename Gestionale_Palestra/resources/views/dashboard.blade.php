<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('I nostri corsi') }}
        </h2>
    </x-slot>

    <div class="p-6">
    @foreach($courses as $course)
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="h5 font-weight-bold">Corso: {{ $course->name }}</h3>
                <img src="{{ $course->image }}" alt="" class="rounded">
                <p><strong>Durata:</strong> {{ $course->duration }}</p>
                <p><strong>Descrizione:</strong> {{ $course->description }}</p>
                <p><strong>Prezzo:</strong> {{ $course->price }} €</p>

                <h4 class="h5 font-weight-bold mt-2">Attività principali</h4>
                @foreach($course->activities as $activity)
                    <div class="py-2 border-top">
                        <h5 class="h6 font-weight-bold">{{ $activity->name }}</h5>
                        <img src="{{ $activity->image }}" alt="" class="rounded" width="200">
                        <p>{{ $activity->description }}</p>
                    </div>
                @endforeach

@if($course->reservation === null)
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        <button type="submit" class="btn btn-success btn-sm">Prenota</button>
    </form>
@elseif($course->reservation->is_accepted === null)
    <form action="{{ route('reservations.destroy', $course->reservation->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-secondary btn-sm">Cancella prenotazione</button>
        <button class="btn btn-warning btn-sm" disabled>In attesa di conferma</button>
    </form>
@elseif($course->reservation->is_accepted == false)
    <button class="btn btn-danger btn-sm" disabled>Corso al completo</button>
@elseif($course->reservation->is_accepted == true)
    <button class="btn btn-success btn-sm" disabled>Corso confermato</button>
@endif
            </div>
        </div>
    @endforeach
</div>

</x-app-layout>
