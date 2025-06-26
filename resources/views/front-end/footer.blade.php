<footer class="bg-footer-dark text-white mt-5">
    <div class="container px-3 px-sm-4 px-md-5 py-5">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Kolom 1: Logo dan Deskripsi -->
            <div class="col">
                <div class="d-flex flex-column h-100">
                    <img alt="BAZNAS logo with emblem and text Badan Amil Zakat Nasional" class="mb-3" height="80"
                        src="{{ asset('assets/img/logo baznas.png') }}" width="80" />
                    <p class="small flex-grow-1">
                        Badan Amil Zakat Nasional (BAZNAS) menghimpun dan menyalurkan
                        Zakat, Infaq, dan Sedekah (ZIS) dari muzaki kepada mustahik yang
                        membutuhkan melalui berbagai program pendistribusian dan
                        pendayagunaan yang tepat sasaran.
                    </p>
                </div>
            </div>

            <!-- Kolom 2: Tautan -->
            <div class="col">
                <h4 class="fw-semibold mb-3 fs-6">Tautan</h4>
                <ul class="list-unstyled small">
                    <li><a class="text-white text-decoration-none" href="{{ route('tentang-kami') }}">Tentang Kami</a>
                    </li>
                    <li><a class="text-white text-decoration-none" href="{{ route('all-event.index') }}">Event
                            Donasi</a></li>
                    <li><a class="text-white text-decoration-none"
                            href="{{ route('pengajuan-donasi.create') }}">Pengajuan Donasi</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak -->
            <div class="col">
                <h4 class="fw-semibold mb-3 fs-6">Kontak</h4>
                <ul class="list-unstyled small">
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-user"></i><span>KANTOR LAYANAN</span>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-phone"></i>
                        <a class="text-white text-decoration-none" href="tel:081188821818">(0811)88821818</a>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-phone-alt"></i>
                        <a class="text-white text-decoration-none" href="tel:0212289798">(021)2289798</a>
                    </li>
                    <li class="d-flex align-items-start gap-2 mb-2">
                        <i class="fas fa-map-marker-alt mt-1"></i>
                        <address class="mb-0">
                            Jl. Matraman Raya No.134, Kb. Mangga, Kec. Matraman, Jakarta 13150
                        </address>
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-envelope"></i>
                        <a class="text-white text-decoration-none" href="mailto:layananmuzaki@baznas.go.id">
                            layananmuzaki@baznas.go.id
                        </a>
                    </li>
                    <li class="d-flex align-items-center gap-3 mt-3">
                        <a aria-label="Facebook" class="text-white-50 hover-light" href="#"><i
                                class="fab fa-facebook-f"></i></a>
                        <a aria-label="Twitter" class="text-white-50 hover-light" href="#"><i
                                class="fab fa-twitter"></i></a>
                        <a aria-label="Instagram" class="text-white-50 hover-light" href="#"><i
                                class="fab fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-footer-darker text-center text-secondary small py-3">
        Copyright © 2025 Badan Amil Zakat Nasional Provinsi Banten
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

<!-- Owl Carousel Initialization -->
<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
            },
        });
    });
</script>
</body>

</html>
