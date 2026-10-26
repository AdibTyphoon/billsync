<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Alerts / Notifications -->
            @if (session('success'))
                <div class="mb-6 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-sm flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="font-bold">Success</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Header with Personalized Greeting & Glowing Sync Button -->
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                    </h2>
                    <p class="text-gray-500 mt-1 text-sm font-medium">
                        {{ \Carbon\Carbon::now()->format('l, d F Y') }} • Here is your financial overview.
                    </p>
                </div>
                
                <!-- BUTANG SYNC: Ditambah fungsi onclick="tunjukSkrinLoading()" -->
                <a href="{{ url('/baca-emel') }}" onclick="tunjukSkrinLoading()" class="relative inline-flex items-center justify-center px-6 py-2.5 font-bold text-white transition-all duration-200 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-[0_4px_15px_-3px_rgba(79,70,229,0.4)] hover:shadow-[0_8px_25px_-5px_rgba(79,70,229,0.6)] hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Sync Latest Bills
                </a>
            </div>

            <!-- ROW 1: Financial Overview Cards (Split into 2) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                
                <!-- Card 1: Total Outstanding (Red/Warning) -->
                <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-gray-100 flex flex-col justify-between transition duration-300 hover:shadow-md group relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-red-50 rounded-full opacity-50 transition-transform duration-500 group-hover:scale-150"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider group-hover:text-red-500 transition-colors">Total Outstanding</p>
                            <div class="bg-red-100 text-red-600 p-2.5 rounded-2xl shadow-sm transform transition duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-4xl lg:text-5xl font-black text-gray-900 mb-2">
                            RM {{ number_format($totalOutstanding, 2) }}
                        </h3>
                        <p class="text-xs lg:text-sm font-semibold text-red-500 flex items-center mt-4">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                            Requires your attention
                        </p>
                    </div>
                </div>

                <!-- Card 2: Total Paid This Month (Green/Success) -->
                <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-gray-100 flex flex-col justify-between transition duration-300 hover:shadow-md group relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-emerald-50 rounded-full opacity-50 transition-transform duration-500 group-hover:scale-150"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-sm font-bold text-gray-400 uppercase tracking-wider group-hover:text-emerald-500 transition-colors">Paid This Month</p>
                            <div class="bg-emerald-100 text-emerald-600 p-2.5 rounded-2xl shadow-sm transform transition duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-4xl lg:text-5xl font-black text-gray-900 mb-2">
                            RM {{ number_format($totalPaidThisMonth, 2) }}
                        </h3>
                        <p class="text-xs lg:text-sm font-semibold text-emerald-500 flex items-center mt-4">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            Great job managing your bills
                        </p>
                    </div>
                </div>

            </div>

            <!-- ROW 2: Your Active Bills (Fokus Utama Pengguna) -->
            <div class="mb-5 flex justify-between items-center">
                <div class="flex items-center">
                    <h3 class="text-lg font-bold text-gray-900 mr-3">Your Active Bills</h3>
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $bills->count() }} detected</span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($bills as $bill)
                <div class="relative bg-gradient-to-br from-blue-600 to-indigo-900 rounded-3xl p-6 shadow-xl text-white transform transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(79,70,229,0.5)] overflow-hidden group">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 transition-transform duration-500 group-hover:scale-150"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white opacity-10"></div>

                    <div class="relative z-10 flex justify-between items-start">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center font-bold text-white mr-3">
                                {{ substr($bill->biller->biller_name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-blue-100 text-[10px] font-bold tracking-widest uppercase">{{ $bill->biller->biller_name ?? 'Unknown Provider' }}</p>
                                <p class="text-xs font-medium opacity-90 truncate max-w-[120px]">{{ $bill->tajuk_emel }}</p>
                            </div>
                        </div>
                        
                        @if($bill->payment_status == 'unpaid')
                            <span class="bg-red-500/90 backdrop-blur-sm text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wide">
                                Unpaid
                            </span>
                        @else
                            <span class="bg-emerald-500/90 backdrop-blur-sm text-white text-[10px] font-bold px-3 py-1 rounded-full shadow-sm uppercase tracking-wide">
                                Paid
                            </span>
                        @endif
                    </div>

                    <div class="relative z-10 mt-6">
                        <p class="text-blue-200 text-xs mb-1 font-medium">Amount Due</p>
                        <h3 class="text-4xl font-black tracking-tight">RM {{ number_format($bill->amount, 2) }}</h3>
                    </div>

                    <div class="relative z-10 mt-8 pt-4 border-t border-white/20 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] text-blue-200 uppercase tracking-widest font-bold mb-0.5">Due Date</p>
                            <p class="font-bold text-sm">{{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}</p>
                        </div>
                        @if($bill->payment_status == 'unpaid')
                    <div class="flex space-x-2">
                 <!-- Butang Pay Now -->
                            <a href="{{ $bill->payment_url }}" target="_blank" class="bg-white text-indigo-700 text-xs font-bold py-2 px-4 rounded-xl shadow-md hover:bg-gray-50 transition duration-200">
                                Pay Now
                            </a>
        
                <!-- Butang Mark as Paid -->
                        <form action="{{ route('bills.mark-as-paid', $bill->bill_id) }}" method="POST" class="inline">
                 @csrf
                    @method('PATCH')
                            <button type="submit" class="bg-indigo-600 text-white border border-white text-xs font-bold py-2 px-4 rounded-xl shadow-md hover:bg-indigo-500 transition duration-200">
                                 Mark as Paid
                            </button>
                        </form>
                    </div>
                @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- ROW 3: Bottom Section (Analytics & Upcoming Alerts Table) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
                
                <!-- Left: Upcoming Due Dates Alerts (Spans 2 columns) -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-gray-100 transition duration-300 hover:shadow-md flex flex-col h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Upcoming Due Date Alerts</h3>
                        <button class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">View All &rarr;</button>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">Provider</th>
                                    <th class="py-3 px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">Due Date</th>
                                    <th class="py-3 px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">Amount</th>
                                    <th class="py-3 px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($bills->where('payment_status', 'unpaid')->take(5) as $alertBill)
                                <tr class="hover:bg-indigo-50/50 transition duration-150 group">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs mr-3 group-hover:bg-indigo-200 transition">
                                                {{ substr($alertBill->biller->biller_name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="font-bold text-sm text-gray-800">{{ $alertBill->biller->biller_name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-sm text-red-600 font-bold flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($alertBill->due_date)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-4 text-sm font-black text-gray-900">RM {{ number_format($alertBill->amount, 2) }}</td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5 animate-pulse"></span>
                                            Action Required
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if($bills->where('payment_status', 'unpaid')->isEmpty())
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-emerald-100 text-emerald-500 mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900">All caught up!</p>
                                        <p class="text-xs text-gray-500 mt-1">No pending bills require your attention.</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Pie Chart / Analytics -->
                <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-gray-100 transition duration-300 hover:shadow-md flex flex-col h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Spending Analytics</h3>
                    </div>
                    <div class="w-full relative flex-grow min-h-[250px] flex items-center justify-center">
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

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '78%',
                    layout: {
                        padding: 10
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 25,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                boxWidth: 8,
                                font: {
                                    size: 11,
                                    family: "'Inter', sans-serif",
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(17, 24, 39, 0.9)',
                            titleFont: { size: 13, family: "'Inter', sans-serif" },
                            bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    return ' RM ' + context.parsed.toFixed(2);
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!-- ========================================== -->
    <!-- SKRIN LOADING SYNC DENGAN QUOTES KEWANGAN  -->
    <!-- ========================================== -->
    <div id="syncLoadingScreen" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(17, 24, 39, 0.9); z-index: 9999; flex-direction: column; justify-content: center; align-items: center; color: white; text-align: center; font-family: sans-serif; backdrop-filter: blur(8px);">
        
        <!-- Animasi Pusing-Pusing -->
        <div class="loading-spinner"></div>
        
        <h2 style="margin-top: 25px; font-size: 1.5rem; font-weight: bold; color: #60A5FA;">Syncing Your Bills...</h2>
        <p style="color: #9CA3AF; font-size: 0.9rem; margin-top: 5px;">Please wait a moment. Do not close this window.</p>
        
        <!-- Kotak Quote -->
        <div style="margin-top: 40px; max-width: 600px; padding: 20px; background: rgba(255, 255, 255, 0.1); border-radius: 12px; border-left: 5px solid #60A5FA;">
            <p id="quoteText" style="font-size: 1.2rem; font-style: italic; line-height: 1.6; color: #E5E7EB;"></p>
        </div>
    </div>

    <style>
        /* CSS untuk buat spinner pusing */
        .loading-spinner {
            border: 6px solid rgba(255, 255, 255, 0.1);
            border-top: 6px solid #60A5FA;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: putar 1s linear infinite;
        }
        @keyframes putar {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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