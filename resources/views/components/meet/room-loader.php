<!-- Container with centered loader and text -->
<div 
    x-data="{ show: true }"
    x-init="window.addEventListener('app-initialized', () => { show = false })"
    x-show="show"
    x-transition:leave="transition-all duration-[3000ms] ease-in-out"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-[5] translate-y-[-150px]"
    style="z-index: 9999"
    class="h-screen relative w-full bg-white flex flex-col justify-center items-center space-y-4"
>
    <div class="loader"></div>
    <div class="text-xl font-semibold text-gray-700 font-poppins">Lara Meet By @princevora</div>
</div>

<!-- Loader Style -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

    .font-poppins {
        font-family: 'Poppins', sans-serif;
    }

    body {
        overflow: hidden;
    }

    .loader {
        width: 60px;
        aspect-ratio: 1;
        background:
            linear-gradient(#60B99A 0 0) calc(1*100%/3) 50%/25% 50%,
            linear-gradient(#60B99A 0 0) calc(2*100%/3) 50%/25% 50%,
            linear-gradient(#f77825 0 0) 50% calc(1*100%/3)/50% 25%,
            linear-gradient(#f77825 0 0) 50% calc(2*100%/3)/50% 25%,
            linear-gradient(#554236 0 0) calc(1*100%/3) calc(1*100%/3)/25% 25%,
            linear-gradient(#554236 0 0) calc(2*100%/3) calc(1*100%/3)/25% 25%,
            linear-gradient(#554236 0 0) calc(1*100%/3) calc(2*100%/3)/25% 25%,
            linear-gradient(#554236 0 0) calc(2*100%/3) calc(2*100%/3)/25% 25%;
        background-repeat: no-repeat;
        animation: l19 1s infinite alternate;
    }

    @keyframes l19 {
        90%, 100% {
            background-position: 0 50%, 100% 50%, 50% 0, 50% 100%, 0 0, 100% 0, 0 100%, 100% 100%
        }
    }
</style>
