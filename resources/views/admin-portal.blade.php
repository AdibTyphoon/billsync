<x-app-layout>
    @php
        // Parsing success rate, clamped to 0-100 so the bar never overflows.
        $rate = max(0, min(100, (float) $parsingSuccessRate));
        $rateBar = $rate >= 95 ? 'bg-emerald-500' : ($rate >= 85 ? 'bg-indigo-500' : 'bg-amber-500');

        // Category badge styles (full class strings so Tailwind can detect them).
        $catStyles = [
            'Utility'      => 'bg-sky-50 text-sky-700 ring-sky-200',
            'Subscription' => 'bg-violet-50 text-violet-700 ring-violet-200',
            'Service'      => 'bg-slate-100 text-slate-700 ring-slate-200',
            'Telco'        => 'bg-amber-50 text-amber-700 ring-amber-200',
        ];

        $billerCount    = count($billers);
        $inputClass     = 'w-full rounded-lg border-slate-300 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500';
        $regexClass     = 'w-full rounded-lg border-slate-300 bg-white font-mono text-xs shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500';
    @endphp

    <style>
        .bs-backdrop {
            background-image:
                radial-gradient(60rem 24rem at 12% -8%, rgba(99, 102, 241, .10), transparent 60%),
                radial-gradient(48rem 20rem at 92% 0%, rgba(14, 165, 233, .08), transparent 60%);
        }
        .tabular { font-variant-numeric: tabular-nums; }

        /* Modal open/close transitions */
        .modal-root { opacity: 0; transition: opacity .18s ease; }
        .modal-root.is-open { opacity: 1; }
        .modal-panel { transform: translateY(10px) scale(.98); transition: transform .22s cubic-bezier(.2, .8, .2, 1); }
        .modal-root.is-open .modal-panel { transform: none; }

        @@media (prefers-reduced-motion: reduce) {
            .modal-root, .modal-panel { transition: none; }
        }
    </style>

    <div class="bs-backdrop relative min-h-screen bg-slate-50 py-10 sm:py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Notifikasi Berjaya -->
            @if (session('success'))
                <div role="status" class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 text-emerald-900 shadow-sm backdrop-blur">
                    <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="flex-1 text-sm font-semibold">{{ session('success') }}</p>
                    <button type="button" onclick="this.parentElement.remove()" class="rounded-md p-1 text-emerald-700/70 transition hover:bg-emerald-100 hover:text-emerald-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500" aria-label="Dismiss message">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <!-- Header Section -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-900 shadow-lg shadow-slate-900/20 ring-1 ring-white/10">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight text-slate-900">Admin Portal</h2>
                        <p class="mt-1 max-w-xl text-sm leading-relaxed text-slate-500">Manage billers, sender email addresses, and system health.</p>
                    </div>
                </div>

                <div class="inline-flex items-center gap-2.5 self-start rounded-full border border-slate-200 bg-white/80 py-1.5 pl-1.5 pr-4 text-sm shadow-sm backdrop-blur sm:self-auto">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-600 text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    <span class="text-slate-500">Administrator: <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span></span>
                </div>
            </div>

            <!-- Top Metric Cards -->
            <div class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-3">
                <div class="rounded-2xl border border-white/70 bg-white/80 p-6 shadow-sm ring-1 ring-slate-900/5 backdrop-blur transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="mb-1 text-sm font-medium text-slate-500">Total active users</p>
                            <h3 class="tabular text-4xl font-bold tracking-tight text-slate-900">{{ number_format($totalActiveUsers) }}</h3>
                        </div>
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                            12% this month
                        </span>
                    </div>
                </div>

                <div class="rounded-2xl border border-white/70 bg-white/80 p-6 shadow-sm ring-1 ring-slate-900/5 backdrop-blur transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                    <p class="mb-1 text-sm font-medium text-slate-500">Parsing success rate</p>
                    <h3 class="tabular mb-4 text-4xl font-bold tracking-tight text-slate-900">{{ $parsingSuccessRate }}%</h3>
                    <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $rate }}" aria-label="Parsing success rate">
                        <div class="{{ $rateBar }} h-2 rounded-full transition-all duration-700 ease-out" style="width: {{ $rate }}%"></div>
                    </div>
                </div>

                <div class="rounded-2xl border border-white/70 bg-white/80 p-6 shadow-sm ring-1 ring-slate-900/5 backdrop-blur transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="mb-1 text-sm font-medium text-slate-500">System health status</p>
                            <h3 class="mt-2 text-xl font-bold tracking-tight text-slate-900">All Operational</h3>
                            <p class="mt-1 text-xs text-slate-500">Latest cron job finished 2 mins ago.</p>
                        </div>
                        <span class="relative flex h-10 w-10 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-200">
                            <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400/30 motion-safe:animate-ping" aria-hidden="true"></span>
                            <svg class="relative h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Pending User Subscriptions Table (Disabled - Auto-Approve Active)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-orange-100 mb-8 overflow-hidden">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-900">Pending User Subscriptions</h3>
                        @if($pendingSubscriptions->count() > 0)
                            <span class="ml-3 bg-red-100 text-red-600 text-xs font-bold px-2.5 py-1 rounded-full">{{ $pendingSubscriptions->count() }} New</span>
                        @endif
                    </div>
                </div>
                
                @if($pendingSubscriptions->count() == 0)
                    <div class="text-center py-8 text-gray-400 font-medium text-sm">
                        No pending subscriptions at the moment.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">User Name</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Requested Biller</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Request Date</th>
                                    <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($pendingSubscriptions as $sub)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="py-4 px-4 text-sm font-semibold text-gray-800">{{ $sub->user_name }}</td>
                                    <td class="py-4 px-4 text-sm font-semibold text-indigo-600">{{ $sub->biller_name }}</td>
                                    <td class="py-4 px-4 text-xs font-medium text-gray-500">{{ \Carbon\Carbon::parse($sub->created_at)->format('d M Y, h:i A') }}</td>
                                    <td class="py-4 px-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <!-- Approve Form -->
                                            <form action="{{ url('/admin/subscriptions/' . $sub->sub_id . '/approve') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-xs font-bold text-white bg-emerald-500 hover:bg-emerald-600 px-4 py-1.5 rounded-lg transition shadow-sm">Approve</button>
                                            </form>
                                            
                                            <!-- Reject Form -->
                                            <form action="{{ url('/admin/subscriptions/' . $sub->sub_id . '/reject') }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this request?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800 bg-red-50 px-3 py-1.5 rounded-lg transition">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            --}}

            <!-- Target Biller Configurations Table -->
            <div class="mb-6 overflow-hidden rounded-2xl border border-white/70 bg-white/90 shadow-sm ring-1 ring-slate-900/5 backdrop-blur">

                <!-- Card header -->
                <div class="flex flex-col gap-4 border-b border-slate-100 p-5 sm:p-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold tracking-tight text-slate-900">Target Biller Email Configurations</h3>
                            <p class="tabular text-xs text-slate-500">{{ $billerCount }} {{ \Illuminate\Support\Str::plural('biller', $billerCount) }}</p>
                        </div>
                    </div>

                    <!-- Butang buka modal -->
                    <button type="button" onclick="openModal('addMasterBillerModal')" class="inline-flex items-center justify-center gap-1.5 self-start rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition hover:bg-slate-800 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 active:scale-[.98] lg:self-auto">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"></path></svg>
                        Add biller
                    </button>
                </div>

                <!-- Search + category filters -->
                <div class="flex flex-col gap-3 border-b border-slate-100 bg-slate-50/60 px-5 py-4 sm:px-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="relative w-full lg:max-w-sm">
                        <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"></path></svg>
                        <input id="billerSearch" type="search" autocomplete="off" placeholder="Search by biller or sender email" aria-label="Search billers" class="w-full rounded-xl border-slate-200 bg-white py-2 pl-9 pr-10 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500">
                        <kbd class="pointer-events-none absolute right-3 top-1/2 hidden -translate-y-1/2 rounded border border-slate-200 bg-slate-50 px-1.5 text-[11px] font-medium text-slate-400 sm:block">/</kbd>
                    </div>

                    <div id="categoryFilters" class="flex flex-wrap items-center gap-2" role="group" aria-label="Filter by category">
                        @foreach (['' => 'All', 'Utility' => 'Utility', 'Subscription' => 'Subscription', 'Service' => 'Service', 'Telco' => 'Telco'] as $value => $label)
                            <button type="button" data-filter="{{ $value }}" aria-pressed="{{ $value === '' ? 'true' : 'false' }}" class="filter-pill inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                                {{ $label }}
                                <span data-count="{{ $value }}" class="tabular rounded-full bg-slate-100 px-1.5 text-[11px] font-medium text-slate-500">0</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] border-collapse text-left">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-semibold text-slate-500">
                                <th scope="col" class="px-6 py-3">Biller identity</th>
                                <th scope="col" class="px-4 py-3">Category</th>
                                <th scope="col" class="px-4 py-3">Target sender email</th>
                                <th scope="col" class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="billerRows" class="divide-y divide-slate-100">
                            <!-- Loop Data Biller -->
                            @foreach($billers as $biller)
                            @php
                                $category  = $biller->category ?? 'Service';
                            @endphp
                            <tr data-biller
                                data-category="{{ $category }}"
                                data-search="{{ strtolower($biller->biller_name . ' ' . $biller->sender_email . ' ' . $category) }}"
                                class="transition-colors duration-150 hover:bg-slate-50/80">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 text-sm font-bold uppercase text-slate-600 ring-1 ring-inset ring-slate-200">
                                            {{ substr($biller->biller_name, 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <span class="block truncate text-sm font-semibold text-slate-900">{{ $biller->biller_name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $catStyles[$category] ?? $catStyles['Service'] }}">{{ $category }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="block max-w-[240px] truncate text-sm text-slate-700" title="{{ $biller->sender_email }}">{{ $biller->sender_email }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Edit Button -->
                                        <button type="button" onclick="openModal('editBillerModal{{ $biller->biller_id }}')" class="rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 transition hover:bg-indigo-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">Edit</button>

                                        <!-- Delete Form -->
                                        <form action="{{ url('/admin/billers/' . $biller->biller_id) }}" method="POST" data-name="{{ $biller->biller_name }}" onsubmit="return confirm('WARNING: Deleting ' + this.dataset.name + ' will also remove it from all user monitoring lists. Proceed?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-100 hover:text-rose-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-500">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Empty state: no billers at all -->
                    @if($billerCount === 0)
                        <div class="px-6 py-14 text-center">
                            <p class="text-sm font-semibold text-slate-700">No billers configured yet</p>
                            <p class="mt-1 text-sm text-slate-500">Add your first biller to start parsing bill emails.</p>
                            <button type="button" onclick="openModal('addMasterBillerModal')" class="mt-4 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Add biller</button>
                        </div>
                    @endif

                    <!-- Empty state: filters match nothing -->
                    <div id="noResults" class="hidden px-6 py-14 text-center">
                        <p class="text-sm font-semibold text-slate-700">No billers match your filters</p>
                        <p class="mt-1 text-sm text-slate-500">Try a different name or email, or clear the category filter.</p>
                        <button type="button" id="clearFilters" class="mt-4 rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">Clear filters</button>
                    </div>
                </div>

                <div class="border-t border-slate-100 bg-slate-50/60 px-6 py-3 text-xs text-slate-500">
                    <span id="resultCount" class="tabular font-semibold text-slate-700">{{ $billerCount }}</span> of {{ $billerCount }} billers shown
                </div>
            </div>

            <!-- View Logs Action -->
            <div class="flex justify-center">
                <button type="button" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white/80 px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm backdrop-blur transition hover:border-slate-300 hover:bg-white hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    View Live Email Parsing Logs
                </button>
            </div>
        </div>
    </div>

    <!-- Copy feedback toast -->
    <div id="toast" role="status" aria-live="polite" class="pointer-events-none fixed bottom-6 left-1/2 z-[60] -translate-x-1/2 translate-y-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white opacity-0 shadow-lg transition duration-200"></div>

    <!-- MODAL POP-UP TAMBAH MASTER BILLER -->
    <div id="addMasterBillerModal" data-modal role="dialog" aria-modal="true" aria-labelledby="addBillerTitle" class="modal-root hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/50 p-4 backdrop-blur-sm">
        <div class="modal-panel my-auto w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/5">
            <div class="flex items-start justify-between border-b border-slate-100 px-6 py-5">
                <div>
                    <h3 id="addBillerTitle" class="text-lg font-semibold tracking-tight text-slate-900">Add New Master Biller</h3>
                    <p class="mt-0.5 text-sm text-slate-500">Tell BillSync which sender to watch and how to read its emails.</p>
                </div>
                <button type="button" onclick="closeModal('addMasterBillerModal')" class="-mr-2 -mt-1 rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" aria-label="Close">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ url('/admin/billers') }}" method="POST">
                @csrf
                <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Biller Name</label>
                            <input type="text" name="biller_name" required placeholder="e.g. Maxis" class="{{ $inputClass }}">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Category</label>
                            <select name="category" class="{{ $inputClass }}">
                                <option value="Utility">Utility</option>
                                <option value="Subscription">Subscription</option>
                                <option value="Service">Service</option>
                                <option value="Telco">Telco</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Target Sender Email</label>
                        <input type="email" name="email" required placeholder="e.g. no-reply@maxis.com.my" class="{{ $inputClass }}">
                        <p class="mt-1 text-xs text-slate-500">Emails from this address are picked up by the IMAP parser.</p>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                        <p class="text-sm font-semibold text-slate-700">Parsing Rules (Regex)</p>
                        <p class="mb-4 mt-0.5 text-xs text-slate-500">Wrap the value you want to capture in a group, e.g. <code class="rounded bg-white px-1 font-mono text-[11px] ring-1 ring-slate-200">(\d+\.\d{2})</code>. Both rules are optional and can be added later.</p>
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Amount Regex</label>
                                <input type="text" name="amount_regex" data-regex-input placeholder="e.g. /RM\s?(\d+\.\d{2})/" class="{{ $regexClass }}">
                                <p data-regex-hint class="mt-1 min-h-[1rem] text-xs"></p>
                                <div data-regex-chips="amount_regex" class="mt-1 flex flex-wrap gap-1.5"></div>
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-slate-700">Due Date Regex</label>
                                <input type="text" name="date_regex" data-regex-input placeholder="e.g. /Due Date:\s?(\d{2}\/\d{2}\/\d{4})/" class="{{ $regexClass }}">
                                <p data-regex-hint class="mt-1 min-h-[1rem] text-xs"></p>
                                <div data-regex-chips="date_regex" class="mt-1 flex flex-wrap gap-1.5"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4">
                    <button type="button" onclick="closeModal('addMasterBillerModal')" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 transition hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">Cancel</button>
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">Save Biller</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POP-UP EDIT MASTER BILLER (Dicipta untuk setiap biller) -->
    @foreach($billers as $biller)
    <div id="editBillerModal{{ $biller->biller_id }}" data-modal role="dialog" aria-modal="true" aria-labelledby="editBillerTitle{{ $biller->biller_id }}" class="modal-root hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/50 p-4 backdrop-blur-sm">
        <div class="modal-panel my-auto w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/5">
            <div class="flex items-start justify-between border-b border-slate-100 px-6 py-5">
                <div class="min-w-0">
                    <h3 id="editBillerTitle{{ $biller->biller_id }}" class="text-lg font-semibold tracking-tight text-slate-900">Edit Biller &amp; Regex</h3>
                    <p class="mt-0.5 truncate text-sm text-slate-500">Editing {{ $biller->biller_name }}</p>
                </div>
                <button type="button" onclick="closeModal('editBillerModal{{ $biller->biller_id }}')" class="-mr-2 -mt-1 rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500" aria-label="Close">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ url('/admin/billers/' . $biller->biller_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="max-h-[65vh] space-y-5 overflow-y-auto px-6 py-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Biller Name</label>
                            <input type="text" name="biller_name" value="{{ $biller->biller_name }}" required class="{{ $inputClass }}">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-slate-700">Category</label>
                            <select name="category" class="{{ $inputClass }}">
                                <option value="Utility" {{ $biller->category == 'Utility' ? 'selected' : '' }}>Utility</option>
                                <option value="Subscription" {{ $biller->category == 'Subscription' ? 'selected' : '' }}>Subscription</option>
                                <option value="Service" {{ $biller->category == 'Service' ? 'selected' : '' }}>Service</option>
                                <option value="Telco" {{ $biller->category == 'Telco' ? 'selected' : '' }}>Telco</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-semibold text-slate-700">Target Sender Email</label>
                        <input type="email" name="email" value="{{ $biller->sender_email }}" required class="{{ $inputClass }}">
                    </div>

                    <div class="rounded-xl border border-indigo-100 bg-indigo-50/60 p-4">
                        <p class="text-sm font-semibold text-indigo-900">Parsing Rules (Regex)</p>
                        <p class="mb-4 mt-0.5 text-xs text-indigo-800/70">Wrap the value you want to capture in a group, e.g. <code class="rounded bg-white px-1 font-mono text-[11px] ring-1 ring-indigo-100">(\d+\.\d{2})</code>.</p>
                        <div class="space-y-4">
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-indigo-900">Amount Regex</label>
                                <input type="text" name="amount_regex" value="{{ $biller->amount_regex }}" data-regex-input class="{{ $regexClass }} border-indigo-200">
                                <p data-regex-hint class="mt-1 min-h-[1rem] text-xs"></p>
                                <div data-regex-chips="amount_regex" class="mt-1 flex flex-wrap gap-1.5"></div>
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-semibold text-indigo-900">Due Date Regex</label>
                                <input type="text" name="date_regex" value="{{ $biller->date_regex }}" data-regex-input class="{{ $regexClass }} border-indigo-200">
                                <p data-regex-hint class="mt-1 min-h-[1rem] text-xs"></p>
                                <div data-regex-chips="date_regex" class="mt-1 flex flex-wrap gap-1.5"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-slate-100 bg-slate-50/70 px-6 py-4">
                    <button type="button" onclick="closeModal('editBillerModal{{ $biller->biller_id }}')" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-inset ring-slate-200 transition hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">Cancel</button>
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">Update Settings</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <script>
        (function () {
            /* ---------- Modals: open/close, backdrop click, Esc ---------- */
            function syncScrollLock() {
                var anyOpen = document.querySelector('[data-modal].is-open');
                document.documentElement.classList.toggle('overflow-hidden', !!anyOpen);
            }

            window.openModal = function (id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.classList.remove('hidden');
                requestAnimationFrame(function () {
                    el.classList.add('is-open');
                    var first = el.querySelector('input:not([type=hidden]), select');
                    if (first) first.focus({ preventScroll: true });
                });
                el.querySelectorAll('[data-regex-input]').forEach(checkRegex);
                syncScrollLock();
            };

            window.closeModal = function (id) {
                var el = document.getElementById(id);
                if (!el) return;
                el.classList.remove('is-open');
                syncScrollLock();
                setTimeout(function () {
                    if (!el.classList.contains('is-open')) el.classList.add('hidden');
                }, 200);
            };

            document.addEventListener('click', function (e) {
                if (e.target.matches && e.target.matches('[data-modal]')) closeModal(e.target.id);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('[data-modal].is-open').forEach(function (m) { closeModal(m.id); });
                }
                var tag = (document.activeElement && document.activeElement.tagName) || '';
                if (e.key === '/' && !/INPUT|TEXTAREA|SELECT/.test(tag) && !document.querySelector('[data-modal].is-open')) {
                    e.preventDefault();
                    var s = document.getElementById('billerSearch');
                    if (s) s.focus();
                }
            });

            /* ---------- Toast + copy to clipboard ---------- */
            var toast = document.getElementById('toast');
            var toastTimer;
            function showToast(msg) {
                toast.textContent = msg;
                toast.classList.remove('opacity-0', 'translate-y-2');
                clearTimeout(toastTimer);
                toastTimer = setTimeout(function () {
                    toast.classList.add('opacity-0', 'translate-y-2');
                }, 1800);
            }

            function copyText(text) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    return navigator.clipboard.writeText(text);
                }
                return new Promise(function (resolve, reject) {
                    var ta = document.createElement('textarea');
                    ta.value = text;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    try { document.execCommand('copy') ? resolve() : reject(); } catch (err) { reject(err); }
                    document.body.removeChild(ta);
                });
            }

            document.addEventListener('click', function (e) {
                var btn = e.target.closest('[data-copy]');
                if (!btn) return;
                copyText(btn.getAttribute('data-copy'))
                    .then(function () { showToast((btn.getAttribute('data-label') || 'Pattern') + ' copied'); })
                    .catch(function () { showToast('Copy failed. Select the pattern manually.'); });
            });

            /* ---------- Biller table: search + category filter ---------- */
            var rows = Array.prototype.slice.call(document.querySelectorAll('#billerRows tr[data-biller]'));
            var search = document.getElementById('billerSearch');
            var pills = Array.prototype.slice.call(document.querySelectorAll('.filter-pill'));
            var noResults = document.getElementById('noResults');
            var resultCount = document.getElementById('resultCount');
            var activeCategory = '';

            var activeCls = ['bg-slate-900', 'text-white', 'border-slate-900', 'hover:bg-slate-800'];
            var idleCls = ['bg-white', 'text-slate-600', 'border-slate-200', 'hover:bg-slate-50'];

            // Per-category counts
            document.querySelectorAll('[data-count]').forEach(function (el) {
                var cat = el.getAttribute('data-count');
                el.textContent = cat === '' ? rows.length : rows.filter(function (r) { return r.dataset.category === cat; }).length;
            });

            function applyFilters() {
                var q = (search.value || '').trim().toLowerCase();
                var visible = 0;
                rows.forEach(function (row) {
                    var match = (!activeCategory || row.dataset.category === activeCategory) &&
                                (!q || row.dataset.search.indexOf(q) !== -1);
                    row.classList.toggle('hidden', !match);
                    if (match) visible++;
                });
                resultCount.textContent = visible;
                noResults.classList.toggle('hidden', !(rows.length > 0 && visible === 0));

                pills.forEach(function (p) {
                    var on = p.getAttribute('data-filter') === activeCategory;
                    p.setAttribute('aria-pressed', on ? 'true' : 'false');
                    var c = p.querySelector('[data-count]');
                    activeCls.concat(idleCls).forEach(function (cls) { p.classList.remove(cls); });
                    (on ? activeCls : idleCls).forEach(function (cls) { p.classList.add(cls); });
                    if (c) {
                        c.classList.toggle('bg-white/15', on);
                        c.classList.toggle('text-white', on);
                        c.classList.toggle('bg-slate-100', !on);
                        c.classList.toggle('text-slate-500', !on);
                    }
                });
            }

            pills.forEach(function (p) {
                p.addEventListener('click', function () {
                    activeCategory = p.getAttribute('data-filter');
                    applyFilters();
                });
            });
            search.addEventListener('input', applyFilters);
            search.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && search.value) { search.value = ''; applyFilters(); e.stopPropagation(); }
            });
            document.getElementById('clearFilters').addEventListener('click', function () {
                search.value = '';
                activeCategory = '';
                applyFilters();
                search.focus();
            });
            applyFilters();

            /* ---------- Regex helpers: example chips + syntax check ---------- */
            var examples = {
                amount_regex: [
                    { label: 'RM 1,234.50', value: String.raw`/RM\s?(\d{1,3}(?:,\d{3})*\.\d{2})/` },
                    { label: 'Amount Due / Jumlah', value: String.raw`/(?:Amount Due|Jumlah)[^\d]{0,20}(\d{1,3}(?:,\d{3})*\.\d{2})/i` }
                ],
                date_regex: [
                    { label: 'DD/MM/YYYY', value: String.raw`/Due Date:\s?(\d{2}\/\d{2}\/\d{4})/` },
                    { label: '15 Dec 2026', value: String.raw`/(?:Due Date|Tarikh Akhir)[:\s]+(\d{1,2}\s[A-Za-z]{3,9}\s\d{4})/i` }
                ]
            };

            function checkRegex(input) {
                var hint = input.parentElement.querySelector('[data-regex-hint]');
                var v = input.value.trim();
                input.classList.remove('border-emerald-400', 'border-rose-400');
                if (!hint) return;
                hint.textContent = '';
                hint.className = 'mt-1 min-h-[1rem] text-xs';
                if (!v) return;
                try {
                    var m = v.match(/^\/([\s\S]*)\/([a-z]*)$/i);
                    new RegExp(m ? m[1] : v, m ? m[2].replace(/[^gimsuy]/g, '') : '');
                    input.classList.add('border-emerald-400');
                    hint.textContent = 'Syntax looks valid';
                    hint.classList.add('text-emerald-600');
                } catch (err) {
                    input.classList.add('border-rose-400');
                    hint.textContent = 'This pattern has a syntax error';
                    hint.classList.add('text-rose-600');
                }
            }

            document.querySelectorAll('[data-regex-chips]').forEach(function (box) {
                var field = box.getAttribute('data-regex-chips');
                var label = document.createElement('span');
                label.className = 'self-center text-[11px] text-slate-500';
                label.textContent = 'Try:';
                box.appendChild(label);
                (examples[field] || []).forEach(function (ex) {
                    var b = document.createElement('button');
                    b.type = 'button';
                    b.textContent = ex.label;
                    b.title = ex.value;
                    b.className = 'rounded-md bg-white px-2 py-1 text-[11px] font-medium text-slate-600 ring-1 ring-inset ring-slate-200 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500';
                    b.addEventListener('click', function () {
                        var input = box.closest('form').querySelector('[name="' + field + '"]');
                        input.value = ex.value;
                        checkRegex(input);
                        input.focus();
                    });
                    box.appendChild(b);
                });
            });

            document.querySelectorAll('[data-regex-input]').forEach(function (input) {
                input.addEventListener('input', function () { checkRegex(input); });
            });
        })();
    </script>
</x-app-layout>
