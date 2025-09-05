<x-layouts.app>
    <div class="container mx-auto px-4 py-8 md:py-12">

        @if(session('success'))
            <div class="alert alert-success shadow-lg mb-6">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 md:p-10 max-w-lg mx-auto transition-colors duration-300">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-900 dark:text-gray-100">Submit a Complaint</h2>

            <form action="{{ route('complaints.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Category -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700 dark:text-gray-200">Category</span>
                    </label>
                    <select name="category" class="select select-bordered w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                        required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="canteen">Canteen / Food Services</option>
                        <option value="sports">Sports / Gym / Facilities</option>
                        <option value="library">Library / Study Resources</option>
                        <option value="hostel">Hostel / Accommodation</option>
                        <option value="transport">Transport / Parking</option>
                        <option value="faculty">Faculty / Teaching Issues</option>
                        <option value="administration">Administration / Office Services</option>
                        <option value="events">Events / Campus Activities</option>
                        <option value="safety">Safety / Security</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Complaint Text -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text font-medium text-gray-700 dark:text-gray-200">Complaint</span>
                    </label>
                    <textarea name="complaint_text" rows="5" placeholder="Type your complaint here..."
                        class="textarea textarea-bordered w-full resize-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
                        required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="form-control mt-4">
                    <button type="submit" class="btn btn-primary w-full text-white">Submit Complaint</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
