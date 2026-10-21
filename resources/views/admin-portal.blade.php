<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <!-- Target Biller Configurations Table -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <h3 class="text-lg font-bold text-gray-900">Target Biller Email Configurations</h3>
                    </div>
                    <button class="bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold py-2 px-4 rounded-xl transition duration-200 shadow-md">
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
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">Parsing Status</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            
                            <!-- TNB Row -->
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold text-xs mr-3">T</div>
                                        <span class="text-sm font-semibold text-gray-800">TNB</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm font-semibold text-gray-500">Utility</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">no-reply@tnb.com.my</td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wide">Active</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button class="text-xs font-bold text-blue-600 hover:text-blue-800">Edit Regex Rules</button>
                                </td>
                            </tr>

                            <!-- CelcomDigi Row -->
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs mr-3">C</div>
                                        <span class="text-sm font-semibold text-gray-800">CelcomDigi / Unifi</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm font-semibold text-gray-500">Telco</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">ebilling@celcom.com.my</td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wide">Active</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button class="text-xs font-bold text-blue-600 hover:text-blue-800">Edit Regex Rules</button>
                                </td>
                            </tr>

                            <!-- Netflix Row -->
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-xs mr-3">N</div>
                                        <span class="text-sm font-semibold text-gray-800">Netflix</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm font-semibold text-gray-500">Subscription</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">receipts@netflix.com</td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wide">Active</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button class="text-xs font-bold text-blue-600 hover:text-blue-800">Edit Regex Rules</button>
                                </td>
                            </tr>

                            <!-- Spotify Row -->
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-bold text-xs mr-3">S</div>
                                        <span class="text-sm font-semibold text-gray-800">Spotify</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm font-semibold text-gray-500">Subscription</td>
                                <td class="py-4 px-4 text-sm font-medium text-gray-800">no-reply@spotify.com</td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-800 uppercase tracking-wide">Maintenance</span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button class="text-xs font-bold text-blue-600 hover:text-blue-800">Edit Regex Rules</button>
                                </td>
                            </tr>

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
</x-app-layout>