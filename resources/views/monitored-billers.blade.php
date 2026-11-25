<x-app-layout>
    <div class="relative min-h-screen bg-slate-50 py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow-sm" role="status">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-600 shadow-sm">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </span>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-800 shadow-sm" role="alert">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-rose-600 shadow-sm">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </span>
                    <p class="text-sm font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            <header class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mb-3 flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/20">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </span>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">BillSync connections</p>
                            <h1 class="mt-0.5 text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">Monitored Billers</h1>
                        </div>
                    </div>
                    <p class="max-w-xl text-sm text-slate-500">Manage the billers BillSync checks for billing emails and updates.</p>
                </div>

                <button type="button"
                        onclick="openAddBillerModal()"
                        class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add New Biller
                </button>
            </header>

            <section aria-label="Biller summary and filters">
                <div class="mb-5 flex flex-col gap-4 rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm shadow-slate-900/5 sm:flex-row sm:items-center sm:justify-between sm:px-5">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">Your monitored billers</p>
                            <p class="text-xs text-slate-500"><span id="billerVisibleCount">{{ $userBillers->count() }}</span> connections</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2" role="group" aria-label="Filter billers">
                        <button type="button" class="biller-filter rounded-full bg-slate-950 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2" data-filter="all" aria-pressed="true">All</button>
                        <button type="button" class="biller-filter rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2" data-filter="active" aria-pressed="false">Active</button>
                        <button type="button" class="biller-filter rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2" data-filter="pending" aria-pressed="false">Pending</button>
                    </div>
                </div>

                @if($userBillers->isEmpty())
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center shadow-sm">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path></svg>
                        </div>
                        <h2 class="mt-5 text-lg font-bold text-slate-900">No billers connected yet</h2>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Add a biller to start monitoring its billing emails and keep your bills together in BillSync.</p>
                        <button type="button"
                                onclick="openAddBillerModal()"
                                class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"></path></svg>
                            Add your first biller
                        </button>
                    </div>
                @else
                    <div id="billerGrid" class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach($userBillers as $biller)
                            @php
                                $isUtility = ($biller->category ?? '') == 'Utility';
                                $isActive = $biller->status == 'active';
                            @endphp

                            <article class="biller-card group overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm shadow-slate-900/5 transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-900/10"
                                     data-status="{{ $isActive ? 'active' : 'pending' }}">
                                <div class="h-1 {{ $isUtility ? 'bg-amber-400' : 'bg-indigo-500' }}"></div>

                                <div class="p-5">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $isUtility ? 'bg-amber-50 text-amber-700 ring-amber-100' : 'bg-indigo-50 text-indigo-700 ring-indigo-100' }} text-sm font-bold ring-1 ring-inset">
                                                {{ substr($biller->biller_name, 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <h2 class="truncate text-sm font-bold text-slate-900">{{ $biller->biller_name }}</h2>
                                                <p class="mt-1 truncate text-xs text-slate-500">{{ $biller->category ?? 'Service' }}</p>
                                            </div>
                                        </div>

                                        @if($isActive)
                                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-700 ring-1 ring-inset ring-amber-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-6">
                                        <p class="mb-2 text-[10px] font-bold uppercase tracking-[0.14em] text-slate-400">Target sender email</p>
                                        <div class="flex min-w-0 items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 p-2">
                                            <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                                            <span class="min-w-0 flex-1 truncate text-xs font-medium text-slate-700" title="{{ $biller->sender_email ?? 'no-reply@provider.com' }}">
                                                {{ $biller->sender_email ?? 'no-reply@provider.com' }}
                                            </span>
                                            <button type="button"
                                                    class="copy-email inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-white hover:text-indigo-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                                                    data-copy="{{ $biller->sender_email ?? 'no-reply@provider.com' }}"
                                                    aria-label="Copy sender email"
                                                    title="Copy sender email">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 8V5a2 2 0 012-2h9a2 2 0 012 2v9a2 2 0 01-2 2h-3M5 8h9a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9a2 2 0 012-2z"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-5 border-t border-slate-100 pt-4">
                                        <form action="{{ url('/billers/' . $biller->pivot_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to stop monitoring {{ $biller->biller_name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-xl border border-rose-100 bg-white px-3 py-2 text-xs font-semibold text-rose-600 transition hover:border-rose-200 hover:bg-rose-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-500 focus-visible:ring-offset-2">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Stop monitoring
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div id="noBillersForFilter" class="mt-5 hidden rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center">
                        <p class="text-sm font-semibold text-slate-800">No billers in this view</p>
                        <p class="mt-1 text-xs text-slate-500">Choose another status filter to see your connections.</p>
                    </div>
                @endif
            </section>
        </div>
    </div>

    <div id="addBillerModal"
         class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4 opacity-0 backdrop-blur-sm transition-opacity duration-200"
         aria-hidden="true">
        <div class="modal-panel w-full max-w-md scale-95 rounded-3xl border border-white/60 bg-white p-6 shadow-2xl shadow-slate-950/25 transition-transform duration-200 sm:p-7"
             role="dialog"
             aria-modal="true"
             aria-labelledby="addBillerModalTitle">
            <div class="mb-6 flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-indigo-600">New connection</p>
                    <h2 id="addBillerModalTitle" class="mt-1 text-xl font-bold tracking-tight text-slate-950">Add New Biller</h2>
                    <p class="mt-1 text-sm text-slate-500">Choose a provider to add to your monitored billers.</p>
                </div>
                <button type="button"
                        onclick="closeAddBillerModal()"
                        class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500"
                        aria-label="Close dialog">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ url('/billers') }}" method="POST">
                @csrf
                <div>
                    <label for="biller_id" class="mb-2 block text-sm font-semibold text-slate-700">Select provider</label>
                    <select id="biller_id" name="biller_id" required
                            class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-3 text-sm text-slate-800 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:ring-indigo-500">
                        <option value="" disabled selected>Choose a registered biller</option>
                        @foreach($masterBillers as $master)
                            <option value="{{ $master->biller_id }}">{{ $master->biller_name }} ({{ $master->category ?? 'Service' }})</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs leading-5 text-slate-500">BillSync will use the provider details to monitor matching billing emails.</p>
                </div>

                <div class="mt-7 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <button type="button"
                            onclick="closeAddBillerModal()"
                            class="inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400 focus-visible:ring-offset-2">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex min-h-10 items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                        Link Biller
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .modal-backdrop.modal-visible {
            opacity: 1;
        }

        .modal-backdrop.modal-visible .modal-panel {
            transform: scale(1);
        }

        @media (prefers-reduced-motion: reduce) {
            .modal-backdrop,
            .modal-panel,
            .biller-card {
                transition: none !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.biller-filter');
            const billerCards = document.querySelectorAll('.biller-card');
            const noBillersForFilter = document.getElementById('noBillersForFilter');
            const billerVisibleCount = document.getElementById('billerVisibleCount');

            filterButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    const selectedFilter = button.dataset.filter;
                    let visibleCount = 0;

                    filterButtons.forEach(function (filterButton) {
                        const isSelected = filterButton === button;
                        filterButton.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
                        filterButton.classList.toggle('bg-slate-950', isSelected);
                        filterButton.classList.toggle('text-white', isSelected);
                        filterButton.classList.toggle('shadow-sm', isSelected);
                        filterButton.classList.toggle('border', !isSelected);
                        filterButton.classList.toggle('border-slate-200', !isSelected);
                        filterButton.classList.toggle('bg-white', !isSelected);
                        filterButton.classList.toggle('text-slate-600', !isSelected);
                    });

                    billerCards.forEach(function (card) {
                        const matches = selectedFilter === 'all' || card.dataset.status === selectedFilter;
                        card.classList.toggle('hidden', !matches);
                        if (matches) visibleCount++;
                    });

                    if (billerVisibleCount) {
                        billerVisibleCount.textContent = visibleCount;
                    }

                    if (noBillersForFilter) {
                        noBillersForFilter.classList.toggle('hidden', visibleCount > 0);
                    }
                });
            });

            document.querySelectorAll('.copy-email').forEach(function (button) {
                button.addEventListener('click', async function () {
                    const email = button.dataset.copy;
                    if (!email) return;

                    try {
                        await navigator.clipboard.writeText(email);
                        const originalTitle = button.title;
                        button.title = 'Copied';
                        button.setAttribute('aria-label', 'Email copied');
                        button.classList.add('text-emerald-600');

                        window.setTimeout(function () {
                            button.title = originalTitle;
                            button.setAttribute('aria-label', 'Copy sender email');
                            button.classList.remove('text-emerald-600');
                        }, 1400);
                    } catch (error) {
                        window.prompt('Copy this sender email:', email);
                    }
                });
            });
        });

        function openAddBillerModal() {
            const modal = document.getElementById('addBillerModal');
            if (!modal) return;

            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');

            window.requestAnimationFrame(function () {
                modal.classList.add('modal-visible');
                const select = modal.querySelector('select[name="biller_id"]');
                if (select) select.focus();
            });
        }

        function closeAddBillerModal() {
            const modal = document.getElementById('addBillerModal');
            if (!modal) return;

            modal.classList.remove('modal-visible');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');

            window.setTimeout(function () {
                if (modal.getAttribute('aria-hidden') === 'true') {
                    modal.classList.add('hidden');
                }
            }, 200);
        }

        document.addEventListener('click', function (event) {
            const modal = document.getElementById('addBillerModal');
            if (modal && event.target === modal) {
                closeAddBillerModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            const modal = document.getElementById('addBillerModal');
            if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeAddBillerModal();
            }
        });
    </script>
</x-app-layout>