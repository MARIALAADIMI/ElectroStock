@if ($paginator->hasPages())
    <nav>
        <div class="pagination-container">
            {{-- Texte d'information à gauche --}}
            <div class="pagination-info">
                Affichage de <strong>{{ $paginator->firstItem() }}</strong> à <strong>{{ $paginator->lastItem() }}</strong> sur <strong>{{ $paginator->total() }}</strong> résultats
            </div>

            {{-- Boutons de pagination à droite --}}
            <ul class="pagination">
                {{-- Bouton Précédent --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                    </li>
                @endif

                {{-- Numéros de page / Séparateur "..." --}}
                @foreach ($elements as $element)
                    {{-- Séparateur "..." --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Liens des numéros de page --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Bouton Suivant --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif