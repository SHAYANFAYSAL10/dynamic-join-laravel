<!-- resources/views/components/modal.blade.php -->

<div x-show="isOpen" x-on:click.away="isOpen = false" class="fixed inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded shadow-lg">
            <!-- Modal content goes here -->
            {{ $slot }}
        </div>
    </div>
</div>
