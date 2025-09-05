<x-layouts.app>
    <div class="container mx-auto p-4">

        @if(session('success'))
            <div class="text-green-600 mb-4">{{ session('success') }}</div>
        @endif

        <h2 class="text-2xl font-bold mb-4">Submit a Complaint</h2>

        <form action="{{ route('complaints.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1">Category:</label>
                <select name="category" class="border rounded w-full p-2" required>
                    <option value="canteen">Canteen</option>
                    <option value="sports">Sports</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label class="block mb-1">Complaint:</label>
                <textarea name="complaint_text" rows="5" class="border rounded w-full p-2" required></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Complaint</button>
        </form>
    </div>
</x-layouts.app>
