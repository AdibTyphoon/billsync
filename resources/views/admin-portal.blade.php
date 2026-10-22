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

            <!-- Header Section -->
            <div class="mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="bg-gray-900 p-2 rounded-lg mr-3 shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        </div>
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Admin Portal</h2>
                    </div>
                    <p class="text-gray-500 mt-1">Manage target biller email addresses, parsing patterns, and system health.</p>
                </div>
                
                <p class="text-sm font-bold text-gray-500 bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
                    Administrator: <span class="text-indigo-600">{{ Auth::user()->name }}</span>
                </p>
            </div>

            <!-- Top Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Active Users</p>
                            <h3 class="text-3xl font-black text-gray-900">12,547</h3>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-1 rounded-md uppercase flex items-center">
                            +12% This Month
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div class="w-full">
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Parsing Success Rate</p>
                            <h3 class="text-3xl font-black text-gray-900 mb-2">99.1%</h3>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="bg-indigo-600 h-1.5 rounded-full" style="width: 99.1%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">System Health Status</p>
                            <h3 class="text-xl font-black text-gray-900 mt-2">All Operational</h3>
                            <p class="text-xs text-gray-500 mt-1">Latest cron job finished 2 mins ago.</p>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 p-2 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Pending User Subscriptions Table -->
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

            <!-- Target Biller Configurations Table -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <h3 class="text-lg font-bold text-gray-900">Target Biller Email Configurations</h3>
                    </div>
                    <!-- Butang buka modal -->
                    <button onclick="document.getElementById('addMasterBillerModal').classList.remove('hidden')" class="bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold py-2 px-4 rounded-xl transition duration-200 shadow-md">
                        + Add Biller
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Biller Identity</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Category</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Target Sender Email</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <!-- Loop Data Biller -->
                            @foreach($billers as $biller)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-xs mr-3 uppercase">
                                            {{ substr($biller->biller_name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-semibold text-gray-800">{{ $biller->biller_name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm font-semibold text-gray-500">{{ $biller->category ?? 'Service' }}</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">{{ $biller->sender_email }}</td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <!-- Edit Button -->
                                        <button onclick="document.getElementById('editBillerModal{{ $biller->biller_id }}').classList.remove('hidden')" class="text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1.5 rounded-lg transition">Edit / Regex</button>
                                        
                                        <!-- Delete Form -->
                                        <form action="{{ url('/admin/billers/' . $biller->biller_id) }}" method="POST" onsubmit="return confirm('WARNING: Deleting {{ $biller->biller_name }} will also remove it from all user monitoring lists. Proceed?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800 bg-red-50 px-3 py-1.5 rounded-lg transition">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- View Logs Action -->
            <div class="text-center">
                <button class="text-sm font-bold text-gray-500 hover:text-gray-900 transition flex items-center justify-center w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    View Live Email Parsing Logs
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL POP-UP TAMBAH MASTER BILLER -->
    <div id="addMasterBillerModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 mx-4">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-gray-900">Add New Master Biller</h3>
                <button onclick="document.getElementById('addMasterBillerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ url('/admin/billers') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Biller Name</label>
                            <input type="text" name="biller_name" required placeholder="e.g. Maxis" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Category</label>
                            <select name="category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="Utility">Utility</option>
                                <option value="Subscription">Subscription</option>
                                <option value="Service">Service</option>
                                <option value="Telco">Telco</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Target Sender Email</label>
                        <input type="email" name="email" required placeholder="e.g. no-reply@maxis.com.my" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 mb-3 uppercase tracking-wider">Parsing Rules (Regex)</p>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Amount Regex</label>
                                <input type="text" name="amount_regex" placeholder="e.g. /RM\s?(\d+\.\d{2})/" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-xs font-mono">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Due Date Regex</label>
                                <input type="text" name="date_regex" placeholder="e.g. /Due Date:\s?(\d{2}\/\d{2}\/\d{4})/" class="w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-xs font-mono">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('addMasterBillerModal').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 text-sm">Save Biller</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POP-UP EDIT MASTER BILLER (Dicipta untuk setiap biller) -->
    @foreach($billers as $biller)
    <div id="editBillerModal{{ $biller->biller_id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 mx-4">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-lg font-bold text-gray-900">Edit Biller & Regex</h3>
                <button onclick="document.getElementById('editBillerModal{{ $biller->biller_id }}').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form action="{{ url('/admin/billers/' . $biller->biller_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Biller Name</label>
                            <input type="text" name="biller_name" value="{{ $biller->biller_name }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Category</label>
                            <select name="category" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="Utility" {{ $biller->category == 'Utility' ? 'selected' : '' }}>Utility</option>
                                <option value="Subscription" {{ $biller->category == 'Subscription' ? 'selected' : '' }}>Subscription</option>
                                <option value="Service" {{ $biller->category == 'Service' ? 'selected' : '' }}>Service</option>
                                <option value="Telco" {{ $biller->category == 'Telco' ? 'selected' : '' }}>Telco</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Target Sender Email</label>
                        <input type="email" name="email" value="{{ $biller->sender_email }}" required class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-100">
                        <p class="text-xs font-bold text-indigo-800 mb-3 uppercase tracking-wider">Parsing Rules (Regex)</p>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-indigo-900 mb-1">Amount Regex</label>
                                <input type="text" name="amount_regex" value="{{ $biller->amount_regex }}" class="w-full rounded-md border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 text-xs font-mono bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-indigo-900 mb-1">Due Date Regex</label>
                                <input type="text" name="date_regex" value="{{ $biller->date_regex }}" class="w-full rounded-md border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 text-xs font-mono bg-white">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editBillerModal{{ $biller->biller_id }}').classList.add('hidden')" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 text-sm">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 text-sm">Update Settings</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

</x-app-layout>