<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="bg-indigo-600 p-2 rounded-lg mr-3 shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Monitored Billers & Email Sync</h2>
                    </div>
                    <p class="text-gray-500 mt-1">Manage your connected automated billing feeds and synchronization statuses.</p>
                </div>
                
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 px-5 rounded-xl shadow-lg transition duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Biller
                </button>
            </div>

            <!-- Biller Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                
                @foreach($billers as $biller)
                <!-- Dynamic Biller Card -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border-t-4 @if($biller->category == 'Utility') border-yellow-400 @else border-blue-500 @endif hover:shadow-md transition duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600 mr-3">
                                {{ substr($biller->biller_name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $biller->biller_name }}</h3>
                                <p class="text-xs text-gray-500">{{ $biller->category ?? 'Service' }}</p>
                            </div>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wide flex items-center">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1"></span> Active
                        </span>
                    </div>
                    
                    <div class="space-y-3 mt-6">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Target Sender Email</p>
                            <p class="text-xs font-medium text-gray-800 bg-gray-50 p-2 rounded border border-gray-100 truncate">
                                {{ $biller->sender_email ?? 'no-reply@provider.com' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Last Extraction Status</p>
                            <p class="text-xs font-semibold text-gray-600 flex items-center mt-2">
                        <svg class="w-4 h-4 mr-1.5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Success (Today, 08:30 AM)
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <button class="text-xs font-bold text-blue-600 hover:text-blue-800 transition w-full text-center">
                            + View Parsing Logs
                        </button>
                    </div>
                </div>
                @endforeach

                <!-- Static Dummy Card (Netflix - For visual representation like the proposal) -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border-t-4 border-red-500 hover:shadow-md transition duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center font-bold text-red-600 mr-3">
                                N
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Netflix</h3>
                                <p class="text-xs text-gray-500">Subscription</p>
                            </div>
                        </div>
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wide flex items-center">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1"></span> Paused
                        </span>
                    </div>
                    
                    <div class="space-y-3 mt-6">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Target Sender Email</p>
                            <p class="text-xs font-medium text-gray-800 bg-gray-50 p-2 rounded border border-gray-100 truncate">
                                receipts@netflix.com
                            </p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Last Extraction Status</p>
                            <p class="text-xs font-semibold text-gray-400 flex items-center mt-2">
                        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pending setup
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <button class="text-xs font-bold text-blue-600 hover:text-blue-800 transition w-full text-center">
                            Configure Regex
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>