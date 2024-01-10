import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/Pengajar/**/*.php',
        './resources/views/filament/pengajar/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
