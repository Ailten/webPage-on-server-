
@extends('generic.header')


@section('contend')

<h1 class="text-center title-page">Inventaire !</h1>

<div>

    <!-- TODO: make CSS and HTML properly (with button JS pop up details item) -->

    <div>
        @foreach($items as $item)
            <div>{{ $item->name }}</div>
        @endforeach
    </div>
    

    <div class="input-line submit-line d-flex justify-content-center">
        @if (!$items->onFirstPage())
            <p data-href="{{ $items->previousPageUrl() }}"><-</p>
        @endif

        <p> page: {{ $items->currentPage() }}</p>

        @if ($items->hasMorePages())
            <p data-href="{{ $items->nextPageUrl() }}"><-</p>
        @endif
    </div>

    <div>{{ $items->links() }}</div>
</div>

@endsection