@php
    $currentStatePath = $getStatePath();
    $latitudeStatePath = str_replace('.get_location', '.latitude', $currentStatePath);
    $longitudeStatePath = str_replace('.get_location', '.longitude', $currentStatePath);
@endphp

<div x-data class="flex items-center">
    <button type="button"
        x-on:click="
            if (!navigator.geolocation) {
                alert('Browser tidak mendukung GPS.');
                return;
            }
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    $wire.set(
                        @js($latitudeStatePath),
                        position.coords.latitude
                    );
                    $wire.set(
                        @js($longitudeStatePath),
                        position.coords.longitude
                    );
                    console.log('Latitude:', position.coords.latitude);
                    console.log('Longitude:', position.coords.longitude);
                },
                (error) => {
                    console.error('GPS Error:', error);
                    let message = 'Gagal mendapatkan lokasi.';
                    if (error.code === 1) {
                        message = 'Izin lokasi ditolak oleh browser.';
                    } else if (error.code === 2) {
                        message = 'Lokasi tidak tersedia.';
                    } else if (error.code === 3) {
                        message = 'Waktu pengambilan lokasi habis.';
                    }
                    alert(message);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 15000,
                    maximumAge: 0
                }
            );
        "
        class="fi-btn fi-btn-color-primary inline-flex items-center gap-1.5 rounded-lg px-4 py-2 text-sm font-semibold">
        <x-filament::icon icon="heroicon-o-map-pin" class="h-5 w-5" />
        Ambil Lokasi Saat Ini
    </button>
</div>
