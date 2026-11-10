@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col sm:flex-row items-center justify-between gap-4">

            {{-- Mobile View --}}
            <div class="flex justify-between w-full sm:hidden gap-3">
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed border border-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Previous
                    </span>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-700 bg-white border border-purple-200 rounded-xl hover:bg-purple-50 transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Previous
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-purple-700 bg-white border border-purple-200 rounded-xl hover:bg-purple-50 transition shadow-sm">
                        Next
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed border border-gray-200">
                        Next
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                @endif
            </div>

            {{-- Desktop View --}}
            <div class="hidden sm:flex sm:items-center sm:justify-between w-full gap-4">

                {{-- Showing Results Info Pill --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-full text-xs text-gray-600 shadow-sm">
                    <svg class="w-4 h-4 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h8"/>
                    </svg>
                    <span>
                        Showing
                        @if ($paginator->firstItem())
                            <strong class="font-bold text-purple-700">{{ $paginator->firstItem() }}</strong>
                            to
                            <strong class="font-bold text-purple-700">{{ $paginator->lastItem() }}</strong>
                        @else
                            <strong class="font-bold text-purple-700">{{ $paginator->count() }}</strong>
                        @endif
                        of
                        <strong class="font-bold text-gray-900">{{ number_format($paginator->total()) }}</strong>
                        results
                    </span>
                </div>

                {{-- Page Links --}}
                <div class="flex items-center gap-1.5 flex-wrap">

                    {{-- Previous Page Button --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-gray-300 bg-gray-50 border border-gray-200 rounded-xl cursor-not-allowed select-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Prev
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-purple-700 bg-white border border-purple-200 rounded-xl hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 hover:text-white hover:border-transparent hover:shadow-md transition-all duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            Prev
                        </button>
                    @endif

                    {{-- Numbered Page Links --}}
                    @foreach ($elements as $element)
                        {{-- Dots Separator --}}
                        @if (is_string($element))
                            <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-gray-400 select-none tracking-widest">
                                •••
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                    @if ($page == $paginator->currentPage())
                                        {{-- ACTIVE PAGE: Bold purple-to-indigo gradient with glow --}}
                                        <span aria-current="page"
                                            class="inline-flex items-center justify-center min-w-10 h-10 px-3 text-sm font-black text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg shadow-purple-500/30 ring-2 ring-purple-500 ring-offset-2 cursor-default select-none transform scale-105">
                                            {{ $page }}
                                        </span>
                                    @else
                                        {{-- INACTIVE PAGE: Clean button with purple hover effect --}}
                                        <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                            class="inline-flex items-center justify-center min-w-9 h-9 px-2.5 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-purple-50 hover:text-purple-700 hover:border-purple-300 hover:shadow-sm transition-all duration-150">
                                            {{ $page }}
                                        </button>
                                    @endif
                                </span>
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Button --}}
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-purple-700 bg-white border border-purple-200 rounded-xl hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-600 hover:text-white hover:border-transparent hover:shadow-md transition-all duration-150">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    @else
                        <span class="inline-flex items-center justify-center gap-1 px-3 py-2 text-xs font-semibold text-gray-300 bg-gray-50 border border-gray-200 rounded-xl cursor-not-allowed select-none">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif

                </div>
            </div>
        </nav>
    @endif
</div>
