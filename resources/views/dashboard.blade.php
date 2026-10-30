<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                        <!-- Notifikasi Alert -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 text-sm font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('info') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm font-bold flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Header: greeting + sync -->
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                        Welcome back, {{ explode(' ', Auth::user()->name)[0] }} 👋
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ \Carbon\Carbon::now()->format('l, d F Y') }} &middot; Here is your financial overview.
                    </p>
                </div>

                <!-- BUTANG SYNC: fungsi onclick="tunjukSkrinLoading()" dikekalkan -->
                <a href="{{ url('/baca-emel') }}" onclick="tunjukSkrinLoading()"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Sync Latest Bills
                </a>
            </div>

            <!-- ROW 1: Financial overview -->
            <div class="mb-10 grid grid-cols-1 gap-5 md:grid-cols-5">

                <!-- Card 1: Total Outstanding (the hero) -->
                <div class="relative overflow-hidden rounded-3xl bg-slate-900 p-7 text-white md:col-span-3 lg:p-9">
                    <div class="pointer-events-none absolute -right-16 -top-16 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-24 left-1/3 h-56 w-56 rounded-full bg-blue-500/10 blur-3xl"></div>

                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-slate-300">Total outstanding</p>
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-500/15 px-3 py-1 text-xs font-medium text-red-300 ring-1 ring-inset ring-red-400/30">
                                <span class="h-1.5 w-1.5 animate-pulse rounded-full bg-red-400"></span>
                                Requires your attention
                            </span>
                        </div>

                        <h3 class="mt-5 text-4xl font-bold tracking-tight tabular-nums sm:text-5xl lg:text-6xl">
                            <span class="mr-1 text-2xl font-semibold text-slate-400 lg:text-3xl">RM</span>{{ number_format($totalOutstanding, 2) }}
                        </h3>

                        <p class="mt-6 text-sm text-slate-400">
                            {{ $bills->where('payment_status', 'unpaid')->count() }} unpaid
                            {{ \Illuminate\Support\Str::plural('bill', $bills->where('payment_status', 'unpaid')->count()) }} waiting for payment
                        </p>
                    </div>
                </div>

                <!-- Card 2: Total Paid This Month -->
                <div class="flex flex-col justify-between rounded-3xl border border-slate-200 bg-white p-7 md:col-span-2 lg:p-9">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Paid this month</p>
                        <div class="rounded-xl bg-emerald-50 p-2 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="mt-5 text-3xl font-bold tracking-tight text-slate-900 tabular-nums lg:text-4xl">
                            <span class="mr-1 text-lg font-semibold text-slate-400">RM</span>{{ number_format($totalPaidThisMonth, 2) }}
                        </h3>
                        <p class="mt-6 flex items-center text-sm font-medium text-emerald-600">
                            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            Great job managing your bills
                        </p>
                    </div>
                </div>

            </div>

            <!-- ROW 2: Your Active Bills -->
            <div class="mb-4 flex items-center gap-3">
                <h3 class="text-lg font-semibold text-slate-900">Your active bills</h3>
                <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-100">{{ $bills->count() }} detected</span>
            </div>

            <div class="mb-10 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
                @foreach($bills as $bill)
                    @php
                        $dueDate   = \Carbon\Carbon::parse($bill->due_date);
                        $isUnpaid  = $bill->payment_status == 'unpaid';
                        $isOverdue = $isUnpaid && $dueDate->isPast() && !$dueDate->isToday();
                    @endphp

                    <div class="flex flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white transition hover:border-slate-300 hover:shadow-lg hover:shadow-slate-200/60">
                        <!-- status accent -->
                        <div class="h-1 {{ $isUnpaid ? ($isOverdue ? 'bg-red-500' : 'bg-amber-400') : 'bg-emerald-500' }}"></div>

                        <div class="flex flex-1 flex-col p-6">
                            <!-- Biller + status -->
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex min-w-0 items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-sm font-bold text-indigo-600">
                                        {{ substr($bill->biller->biller_name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-900">{{ $bill->biller->biller_name ?? 'Unknown Provider' }}</p>
                                        <p class="truncate text-xs text-slate-500">{{ $bill->tajuk_emel }}</p>
                                    </div>
                                </div>

                                @if($isUnpaid)
                                    <span class="shrink-0 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-200">Unpaid</span>
                                @else
                                    <span class="shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Paid</span>
                                @endif
                            </div>

                            <!-- Amount -->
                            <div class="mt-6">
                                <p class="text-xs text-slate-500">Amount due</p>
                                <h3 class="mt-1 text-3xl font-bold tracking-tight text-slate-900 tabular-nums">
                                    <span class="mr-0.5 text-base font-semibold text-slate-400">RM</span>{{ number_format($bill->amount, 2) }}
                                </h3>
                            </div>

                            <!-- Due date -->
                            <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-4">
                                <div>
                                    <p class="text-xs text-slate-500">Due date</p>
                                    <p class="text-sm font-semibold text-slate-900">{{ $dueDate->format('d M Y') }}</p>
                                </div>
                                @if($isUnpaid)
                                    <span class="text-xs font-medium {{ $isOverdue ? 'text-red-600' : 'text-amber-600' }}">
                                        {{ $dueDate->diffForHumans() }}
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            @if($isUnpaid)
                                <div class="mt-5 grid grid-cols-2 gap-2">
                                    <!-- Butang Pay Now -->
                                    <a href="{{ $bill->payment_url }}" target="_blank"
                                       class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                                        Pay Now
                                    </a>

                                    <!-- Butang Mark as Paid -->
                                    <form action="{{ route('bills.mark-as-paid', $bill->bill_id) }}" method="POST" class="contents">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-slate-400 focus-visible:ring-offset-2">
                                            Mark as Paid
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ROW 3: Upcoming alerts + analytics -->
            <div class="grid grid-cols-1 items-stretch gap-5 lg:grid-cols-3">

                <!-- Left: Upcoming Due Dates Alerts -->
                <div class="flex h-full flex-col rounded-3xl border border-slate-200 bg-white p-6 lg:col-span-2 lg:p-8">
                    <div class="mb-5 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900">Upcoming due dates</h3>
                        <button class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-800">View all &rarr;</button>
                    </div>

                    <div class="grow overflow-x-auto">
                        <table class="w-full border-collapse text-left">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs text-slate-500">
                                    <th class="px-3 py-3 font-medium">Provider</th>
                                    <th class="px-3 py-3 font-medium">Due date</th>
                                    <th class="px-3 py-3 font-medium">Amount</th>
                                    <th class="px-3 py-3 text-right font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($bills->where('payment_status', 'unpaid')->take(5) as $alertBill)
                                <tr class="group transition hover:bg-slate-50">
                                    <td class="px-3 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-xs font-bold text-indigo-600">
                                                {{ substr($alertBill->biller->biller_name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">{{ $alertBill->biller->biller_name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-4">
                                        <span class="inline-flex items-center gap-1.5 text-sm font-medium text-red-600">
                                            <svg class="h-4 w-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($alertBill->due_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 text-sm font-semibold text-slate-900 tabular-nums">RM {{ number_format($alertBill->amount, 2) }}</td>
                                    <td class="px-3 py-4 text-right">
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-200">
                                            <span class="mr-1.5 h-1.5 w-1.5 animate-pulse rounded-full bg-red-500"></span>
                                            Action required
                                        </span>
                                    </td>
                                </tr>
                                @endforeach

                                @if($bills->where('payment_status', 'unpaid')->isEmpty())
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-500">
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

                <!-- Right: Spending analytics -->
                <div class="flex h-full flex-col rounded-3xl border border-slate-200 bg-white p-6 lg:p-8">
                    <div class="mb-5">
                        <h3 class="text-lg font-semibold text-slate-900">Spending analytics</h3>
                    </div>
                    <div class="relative flex min-h-[260px] w-full grow items-center justify-center">
                        <canvas id="expenseChart"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Chart.js Script Engine -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('expenseChart').getContext('2d');

            const labels = {!! json_encode($chartLabels) !!};
            const data = {!! json_encode($chartValues) !!};
            const total = data.reduce((sum, v) => sum + Number(v || 0), 0);

            // Shows the total in the middle of the doughnut
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
                        backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 6
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
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 8,
                                color: '#475569',
                                font: { size: 11, family: "'Inter', sans-serif", weight: '600' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)',
                            titleFont: { size: 13, family: "'Inter', sans-serif" },
                            bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: function(context) {
                                    return ' RM ' + context.parsed.toFixed(2);
                                }
                            }
                        }
                    }
                },
                plugins: [centerText]
            });
        });
    </script>

    <!-- ========================================== -->
    <!-- SKRIN LOADING SYNC DENGAN QUOTES KEWANGAN  -->
    <!-- ========================================== -->
    <div id="syncLoadingScreen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.92); z-index: 9999; flex-direction: column; justify-content: center; align-items: center; color: white; text-align: center; padding: 24px; backdrop-filter: blur(8px);">

        <!-- Animasi Pusing-Pusing -->
        <div class="loading-spinner"></div>

        <h2 style="margin-top: 25px; font-size: 1.5rem; font-weight: 700; color: #a5b4fc;">Syncing your bills...</h2>
        <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 5px;">Please wait a moment. Do not close this window.</p>

        <!-- Kotak Quote -->
        <div style="margin-top: 40px; max-width: 560px; padding: 20px 24px; background: rgba(255, 255, 255, 0.06); border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.1); border-left: 4px solid #818cf8;">
            <p id="quoteText" style="font-size: 1.05rem; font-style: italic; line-height: 1.6; color: #e2e8f0;"></p>
        </div>
    </div>

    <style>
        /* CSS untuk buat spinner pusing */
        .loading-spinner {
            border: 5px solid rgba(255, 255, 255, 0.1);
            border-top: 5px solid #818cf8;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            animation: putar 1s linear infinite;
        }
        @keyframes putar {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @media (prefers-reduced-motion: reduce) {
            .loading-spinner { animation-duration: 3s; }
        }
    </style>

    <script>
        // Senarai Quotes Kewangan (English Version)
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
            // Pilih nombor rawak berdasarkan jumlah quotes
            let randomIndex = Math.floor(Math.random() * financialQuotes.length);

            // Masukkan teks quote ke dalam HTML
            document.getElementById("quoteText").innerText = '"' + financialQuotes[randomIndex] + '"';

            // Tunjuk skrin hitam
            document.getElementById("syncLoadingScreen").style.display = "flex";
        }
    </script>
    <!-- ========================================== -->

</x-app-layout>