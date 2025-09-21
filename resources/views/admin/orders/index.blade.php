<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Orders') }}
            </h2>
            <a href="{{ route('dashboard') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Orders Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2 text-left">Order ID</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Customer Name</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Total</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2 font-mono text-sm">
                                            #{{ $order->id }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $order->name }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $order->address }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 font-semibold">
                                            ${{ number_format($order->total_amount, 2) }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                @if($order->status == 'pending')
                                                    bg-yellow-100 text-yellow-800
                                                @elseif($order->status == 'completed')
                                                    bg-green-100 text-green-800
                                                @elseif($order->status == 'cancelled')
                                                    bg-red-100 text-red-800
                                                @else
                                                    bg-gray-100 text-gray-800
                                                @endif
                                            ">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-sm">
                                            {{ $order->created_at->format('M j, Y g:i A') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                            No orders found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>