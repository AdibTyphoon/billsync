<x-app-layout>
    <div class="min-h-screen bg-slate-50 py-8 sm:py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 flex items-center gap-2 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm font-semibold text-emerald-700 shadow-sm" role="status">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 flex items-center gap-2 rounded-2xl border border-blue-100 bg-blue-50 p-4 text-sm font-semibold text-blue-700 shadow-sm" role="status">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('info') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 flex items-center gap-2 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm font-semibold text-red-700 shadow-sm" role="alert">
                    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <header class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">BillSync dashboard</p>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">
                        Welcome back, {{ explode(' ', Auth::user()->name)[0] }} 👋
                    </h1>
                    <p class="mt-1.5 text-sm text-slate-500">
                        {{ \Carbon\Carbon::now()->format('l, d F Y') }} <span class="px-1">&middot;</span> Your bills, at a glance.
                    </p>
                </div>

                <a href="{{ url('/baca-emel') }}" onclick="tunjukSkrinLoading()"
                   class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5 hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Sync latest bills
                </a>
            </header>

            <section class="mb-10 grid grid-cols-1 gap-5 md:grid-cols-5" aria-label="Billing overview">
                <div class="relative isolate overflow-hidden rounded-3xl bg-slate-950 p-7 text-white shadow-xl shadow-slate-900/10 md:col-span-3 lg:p-9">
                    <div class="pointer-events-none absolute -right-16 -top-20 -z-10 h-72 w-72 rounded-full bg-indigo-500/25 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-28 left-1/3 -z-10 h-64 w-64 rounded-full bg-sky-500/15 blur-3xl"></div>

                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm font-medium text-slate-300">Total outstanding</p>
                        <span class="inline-flex items-center gap-2 rounded-full bg-rose-400/10 px-3 py-1.5 text-xs font-semibold text-rose-200 ring-1 ring-inset ring-rose-300/20">
                            <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                            Requires attention
                        </span>
                    </div>

                    <h2 class="mt-6 text-4xl font-bold tracking-tight tabular-nums sm:text-5xl lg:text-6xl">
                        <span class="mr-1 text-2xl font-semibold text-slate-400 lg:text-3xl">RM</span>{{ number_format($totalOutstanding, 2) }}
                    </h2>

                    <div class="mt-7 flex items-center gap-2 border-t border-white/10 pt-5 text-sm text-slate-300">
                        <span class="inline-flex h-7 min-w-7 items-center justify-center rounded-lg bg-white/10 px-2 font-semibold tabular-nums text-white">
                            {{ $bills->where('payment_status', 'unpaid')->count() }}
                        </span>
                        <span>
                            unpaid {{ \Illuminate\Support\Str::plural('bill', $bills->where('payment_status', 'unpaid')->count()) }} to review
                        </span>
                    </div>
                </div>

                <div class="flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm shadow-slate-900/5 md:col-span-2 lg:p-9">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Paid this month</p>
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-100">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                    </div>
                    <div>
                        <h2 class="mt-6 text-3xl font-bold tracking-tight text-slate-950 tabular-nums lg:text-4xl">
                            <span class="mr-1 text-lg font-semibold text-slate-400">RM</span>{{ number_format($totalPaidThisMonth, 2) }}
                        </h2>
                        <p class="mt-6 flex items-center gap-2 text-sm font-medium text-emerald-700">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-50">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            Bills marked paid this month
                        </p>
                    </div>
                </div>
            </section>

            <section class="mb-10" aria-labelledby="active-bills-heading">
                <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 id="active-bills-heading" class="text-lg font-bold tracking-tight text-slate-950">Your active bills</h2>
                            <span class="rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-100">{{ $bills->count() }} detected</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">Review due dates and keep your bills up to date.</p>
                    </div>

                    <div class="flex flex-wrap gap-2" role="group" aria-label="Filter bills">
                        <button type="button" class="bill-filter rounded-full bg-slate-950 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2" data-filter="all" aria-pressed="true">All</button>
                        <button type="button" class="bill-filter rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2" data-filter="unpaid" aria-pressed="false">Unpaid</button>
                        <button type="button" class="bill-filter rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2" data-filter="overdue" aria-pressed="false">Overdue</button>
                        <button type="button" class="bill-filter rounded-full border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2" data-filter="paid" aria-pressed="false">Paid</button>
                    </div>
                </div>

                <div id="billCards" class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($bills as $bill)
                        @php
                            $dueDate   = \Carbon\Carbon::parse($bill->due_date);
                            $isUnpaid  = $bill->payment_status == 'unpaid';
                            $isOverdue = $isUnpaid && $dueDate->isPast() && !$dueDate->isToday();
                            $isDueSoon = $isUnpaid && !$isOverdue && $dueDate->isBetween(\Carbon\Carbon::today(), \Carbon\Carbon::today()->copy()->addDays(7)->endOfDay());
                            $billFilter = $isOverdue ? 'overdue' : ($isUnpaid ? 'unpaid' : 'paid');
                        @endphp

                        <article class="bill-card flex flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm shadow-slate-900/5 transition duration-200 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-lg hover:shadow-slate-900/10"
                                 data-status="{{ $billFilter }}">
                            <div class="h-1 {{ $isOverdue ? 'bg-rose-500' : ($isDueSoon ? 'bg-amber-400' : ($isUnpaid ? 'bg-indigo-400' : 'bg-emerald-500')) }}"></div>

                            <div class="flex flex-1 flex-col p-5 sm:p-6">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-sm font-bold text-indigo-700 ring-1 ring-inset ring-indigo-100">
                                            {{ substr($bill->biller->biller_name ?? 'U', 0, 1) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-slate-900">{{ $bill->biller->biller_name ?? 'Unknown Provider' }}</p>
                                            <p class="mt-0.5 truncate text-xs text-slate-500">{{ $bill->tajuk_emel }}</p>
                                        </div>
                                    </div>

                                    @if($isOverdue)
                                        <span class="shrink-0 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">Overdue</span>
                                    @elseif($isDueSoon)
                                        <span class="shrink-0 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">Due soon</span>
                                    @elseif($isUnpaid)
                                        <span class="shrink-0 rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Unpaid</span>
                                    @else
                                        <span class="shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Paid</span>
                                    @endif
                                </div>

                                <div class="mt-7">
                                    <p class="text-xs font-medium text-slate-500">Amount due</p>
                                    <h3 class="mt-1 text-3xl font-bold tracking-tight text-slate-950 tabular-nums">
                                        <span class="mr-0.5 text-base font-semibold text-slate-400">RM</span>{{ number_format($bill->amount, 2) }}
                                    </h3>
                                </div>

                                <div class="mt-6 flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                                    <div>
                                        <p class="text-xs font-medium text-slate-500">Due date</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $dueDate->format('d M Y') }}</p>
                                    </div>
                                    @if($isUnpaid)
                                        <span class="inline-flex items-center gap-1.5 text-right text-xs font-semibold {{ $isOverdue ? 'text-rose-600' : ($isDueSoon ? 'text-amber-700' : 'text-slate-500') }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $isOverdue ? 'bg-rose-500' : ($isDueSoon ? 'bg-amber-400' : 'bg-slate-300') }}"></span>
                                            {{ $dueDate->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>

                                @if($isUnpaid)
                                    <div class="mt-5 border-t border-slate-100 pt-4">
                                        <p class="mb-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Choose an action</p>
                                        <div class="grid grid-cols-2 gap-2">
                                            <a href="{{ $bill->payment_url }}" target="_blank" rel="noopener noreferrer"
                                               class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                                                Open payment link
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>

                                            <form action="{{ route('bills.mark-as-paid', $bill->bill_id) }}" method="POST" class="contents">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="inline-flex min-h-10 w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400 focus-visible:ring-offset-2">
                                                    Mark as paid
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <div id="noBillsForFilter" class="mt-4 hidden rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center">
                    <p class="text-sm font-semibold text-slate-800">No bills in this view</p>
                    <p class="mt-1 text-xs text-slate-500">Choose another filter to see your bills.</p>
                </div>
            </section>

            <section class="grid grid-cols-1 items-stretch gap-5 lg:grid-cols-3" aria-label="Due dates and spending analytics">
                <div class="flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm shadow-slate-900/5 sm:p-6 lg:col-span-2 lg:p-7">
                    <div class="mb-4 flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold tracking-tight text-slate-950">Upcoming due dates</h2>
                            <p class="mt-1 text-sm text-slate-500">Your next bills that need attention.</p>
                        </div>
                        <span class="inline-flex shrink-0 items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-100">
                            {{ $bills->where('payment_status', 'unpaid')->count() }} unpaid
                        </span>
                    </div>

                    <div class="grow overflow-x-auto">
                        <table class="w-full min-w-[560px] border-collapse text-left">
                            <thead>
                                <tr class="border-b border-slate-100 text-[11px] uppercase tracking-wider text-slate-400">
                                    <th class="px-3 py-3 font-semibold">Provider</th>
                                    <th class="px-3 py-3 font-semibold">Due date</th>
                                    <th class="px-3 py-3 font-semibold">Amount</th>
                                    <th class="px-3 py-3 text-right font-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($bills->where('payment_status', 'unpaid')->take(5) as $alertBill)
                                    @php
                                        $alertDueDate = \Carbon\Carbon::parse($alertBill->due_date);
                                        $alertIsOverdue = $alertDueDate->isPast() && !$alertDueDate->isToday();
                                        $alertIsDueSoon = !$alertIsOverdue && $alertDueDate->isBetween(\Carbon\Carbon::today(), \Carbon\Carbon::today()->copy()->addDays(7)->endOfDay());
                                    @endphp
                                    <tr class="group transition hover:bg-slate-50/80">
                                        <td class="px-3 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-xs font-bold text-indigo-700">
                                                    {{ substr($alertBill->biller->biller_name ?? 'U', 0, 1) }}
                                                </div>
                                                <span class="max-w-[180px] truncate text-sm font-semibold text-slate-800">{{ $alertBill->biller->biller_name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4">
                                            <span class="text-sm font-medium {{ $alertIsOverdue ? 'text-rose-600' : ($alertIsDueSoon ? 'text-amber-700' : 'text-slate-600') }}">
                                                {{ $alertDueDate->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-semibold text-slate-900 tabular-nums">RM {{ number_format($alertBill->amount, 2) }}</td>
                                        <td class="px-3 py-4 text-right">
                                            @if($alertIsOverdue)
                                                <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">Overdue</span>
                                            @elseif($alertIsDueSoon)
                                                <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">Due soon</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">Upcoming</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @if($bills->where('payment_status', 'unpaid')->isEmpty())
                                    <tr>
                                        <td colspan="4" class="py-12 text-center">
                                            <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-900">All caught up!</p>
                                            <p class="mt-1 text-xs text-slate-500">No pending bills require your attention.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex h-full flex-col rounded-3xl border border-slate-200/80 bg-white p-5 shadow-sm shadow-slate-900/5 sm:p-6 lg:p-7">
                    <div>
                        <h2 class="text-lg font-bold tracking-tight text-slate-950">Spending analytics</h2>
                        <p class="mt-1 text-sm text-slate-500">A breakdown of your tracked bills.</p>
                    </div>
                    <div class="relative mt-4 flex min-h-[280px] w-full grow items-center justify-center">
                        <canvas id="expenseChart" aria-label="Spending analytics doughnut chart" role="img"></canvas>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartCanvas = document.getElementById('expenseChart');

            if (chartCanvas) {
                const ctx = chartCanvas.getContext('2d');
                const labels = {!! json_encode($chartLabels) !!};
                const data = {!! json_encode($chartValues) !!};
                const total = data.reduce((sum, value) => sum + Number(value || 0), 0);
                const hasChartData = data.some(value => Number(value || 0) > 0);

                const centerText = {
                    id: 'centerText',
                    afterDraw(chart) {
                        const { ctx, chartArea } = chart;
                        if (!chartArea) return;

                        const x = (chartArea.left + chartArea.right) / 2;
                        const y = (chartArea.top + chartArea.bottom) / 2;

                        ctx.save();
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillStyle = '#64748b';
                        ctx.font = "500 12px 'Inter', sans-serif";
                        ctx.fillText('Total', x, y - 14);
                        ctx.fillStyle = '#0f172a';
                        ctx.font = "700 20px 'Inter', sans-serif";
                        ctx.fillText('RM ' + total.toFixed(2), x, y + 10);
                        ctx.restore();
                    }
                };

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: data,
                            backgroundColor: hasChartData
                                ? ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
                                : ['#e2e8f0'],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverOffset: hasChartData ? 6 : 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        layout: { padding: 6 },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 18,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    boxWidth: 8,
                                    color: '#475569',
                                    font: { size: 11, family: "'Inter', sans-serif", weight: '600' }
                                }
                            },
                            tooltip: {
                                enabled: hasChartData,
                                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                titleFont: { size: 13, family: "'Inter', sans-serif" },
                                bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                                padding: 12,
                                cornerRadius: 10,
                                callbacks: {
                                    label: function(context) {
                                        return ' RM ' + Number(context.parsed || 0).toFixed(2);
                                    }
                                }
                            }
                        }
                    },
                    plugins: [centerText]
                });
            }

            const filterButtons = document.querySelectorAll('.bill-filter');
            const billCards = document.querySelectorAll('.bill-card');
            const noBillsForFilter = document.getElementById('noBillsForFilter');

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

                    billCards.forEach(function (card) {
                        const matches = selectedFilter === 'all' || card.dataset.status === selectedFilter;
                        card.classList.toggle('hidden', !matches);
                        if (matches) visibleCount++;
                    });

                    if (noBillsForFilter) {
                        noBillsForFilter.classList.toggle('hidden', visibleCount > 0);
                    }
                });
            });
        });
    </script>

    <div id="syncLoadingScreen" style="display: none; position: fixed; inset: 0; z-index: 9999; flex-direction: column; justify-content: center; align-items: center; color: white; text-align: center; padding: 24px; background: rgba(15, 23, 42, 0.92); backdrop-filter: blur(10px);">
        <div class="loading-spinner" aria-hidden="true"></div>

        <h2 style="margin-top: 25px; font-size: 1.5rem; font-weight: 700; color: #c7d2fe;">Syncing your bills...</h2>
        <p style="color: #cbd5e1; font-size: 0.9rem; margin-top: 5px;">Please wait a moment while we check your latest billing emails.</p>

        <div style="margin-top: 32px; max-width: 560px; padding: 20px 24px; background: rgba(255, 255, 255, 0.06); border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.12); border-left: 4px solid #818cf8;">
            <p id="quoteText" style="font-size: 1.05rem; font-style: italic; line-height: 1.6; color: #e2e8f0;"></p>
        </div>
    </div>

    <style>
        .loading-spinner {
            width: 56px;
            height: 56px;
            border: 5px solid rgba(255, 255, 255, 0.12);
            border-top-color: #818cf8;
            border-radius: 50%;
            animation: putar 1s linear infinite;
        }

        @keyframes putar {
            to { transform: rotate(360deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            .loading-spinner { animation-duration: 3s; }
            .bill-card { transition: none; }
        }
    </style>

    <script>
        const financialQuotes = [
            "Little by little becomes a mountain. Just make sure it's not a mountain of debt!",
            "A big salary means nothing without good money management. Live within your means.",
            "The money you save today are the soldiers that will save you tomorrow.",
            "Don't buy things you don't need, with money you don't have, to impress people you don't like.",
            "Wealth isn't about how much money you make, but how much money you keep.",
            "Financial discipline starts with tracking every penny. Great job keeping your bills in check!",
            "Debt is like a shadow. The faster you run, the faster it follows. Face it and clear it!",
            "Rule No. 1: Never lose money. Rule No. 2: Never forget rule No. 1. – Warren Buffett",
            "A budget is telling your money where to go, instead of wondering where it went."
        ];

        function tunjukSkrinLoading() {
            const quoteText = document.getElementById("quoteText");
            const syncLoadingScreen = document.getElementById("syncLoadingScreen");

            if (!quoteText || !syncLoadingScreen) return;

            const randomIndex = Math.floor(Math.random() * financialQuotes.length);
            quoteText.innerText = '"' + financialQuotes[randomIndex] + '"';
            syncLoadingScreen.style.display = "flex";
        }
    </script>
</x-app-layout>