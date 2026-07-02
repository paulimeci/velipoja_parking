<style>
    /* Stilimi për ngarkuesin */
    .loader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.91); /* Gjysmë transparencë për sfondin */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        visibility: hidden; /* Ndihmon që ngarkuesi të mos shfaqet menjëherë */
    }

    .loader {
        border: 16px solid #f3f3f3; /* Ngjyra e jashtme */
        border-top: 16px solid #71dd37; /* Ngjyra e lëvizshme */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    /* Animimi i rotacionit */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Për t'u siguruar që ngarkuesi është responsive */
    @media (max-width: 768px) {
        .loader {
            width: 80px;
            height: 80px;
        }
    }


</style>
<div class="loader-container" id="loader">
    <div class="loader"></div>
</div>

<script>
    window.addEventListener('load', function() {
        // Fshi ngarkuesin pasi faqja është ngarkuar plotësisht
        const loader = document.getElementById('loader');
        loader.style.visibility = 'hidden';
    });

    window.addEventListener('beforeunload', function() {
        // Shfaq ngarkuesin menjëherë kur kërkesa bëhet
        const loader = document.getElementById('loader');
        loader.style.visibility = 'visible';
    });

</script>
