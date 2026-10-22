<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen relative">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi Berjaya -->
            @if (session('success'))
                <div class="mb-6 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="font-bold text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Header Section -->
            <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="bg-indigo-600 p-2 rounded-lg mr-3 shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Monitored Billers</h2>
                    </div>
                    <p class="text-gray-500 mt-1">Manage your connected automated billing feeds.</p>
                </div>
                
                <!-- Butang Buka Modal -->
                <button onclick="document.getElementById('addBillerModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 px-5 rounded-xl shadow-lg transition duration-200 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add New Biller
                </button>
            </div>

            <!-- Biller Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
                @foreach($userBillers as $biller)
                <div class="bg-white rounded-3xl p-6 shadow-sm border-t-4 @if(($biller->category ?? '') == 'Utility') border-yellow-400 @else border-blue-500 @endif hover:shadow-md transition duration-300">
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
                        
                        <!-- Lencana Active & Butang Delete -->
                        <div class="flex items-center gap-2">
                            @if(($biller->status ?? 'active') == 'pending')
                            <!-- Badge Pending (Kuning) -->
                            <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wide flex items-center">
                                <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1 animate-pulse"></span> Pending
                            </span>
                            @else
                            <!-- Badge Active (Hijau) -->
                            <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase tracking-wide flex items-center">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1"></span> Active
                            </span>
                            @endif
                            
                            <!-- Form Delete Biller -->
                            <form action="{{ url('/billers/' . $biller->pivot_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to stop monitoring {{ $biller->biller_name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition bg-red-50 p-1.5 rounded-md" title="Delete Biller">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mt-6">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Target Sender Email</p>
                            <p class="text-xs font-medium text-gray-800 bg-gray-50 p-2 rounded border border-gray-100 truncate">
                                {{ $biller->sender_email ?? 'no-reply@provider.com' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- MODAL POP-UP TAMBAH BILLER -->
    <div id="addBillerModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 mx-4">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-gray-900">Add New Biller</h3>
                <button onclick="document.getElementById('addBillerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ url('/billers') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Select Provider</label>
                        <select name="biller_id" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="" disabled selected>-- Choose a registered biller --</option>
                            @foreach($masterBillers as $master)
                                <option value="{{ $master->biller_id }}">{{ $master->biller_name }} ({{ $master->category ?? 'Service' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addBillerModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 text-sm">Link Biller</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>