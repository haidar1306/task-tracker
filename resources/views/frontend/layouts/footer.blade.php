<footer class="footer">

    <div class="container">

        <div class="row">

            <div class="col-lg-4">
                <h4>Luxury Hotel</h4>
                <p>
                    Experience luxury hospitality,
                    premium rooms and world class service.
                </p>
            </div>

            <div class="col-lg-4">
                <h4>Quick Links</h4>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Rooms</a></li>
                    <li><a href="#">Gallery</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h4>Customer</h4>
                <ul class="list-unstyled">
                    <li><a href="#">My Bookings</a></li>
                    <li><a href="#">Payments</a></li>
                    <li><a href="{{ route('frontend.user.account') }}">Profile</a></li>
                    <li><a href="{{ route('frontend.auth.logout') }}">Logout</a></li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p class="mb-1">© {{ date('Y') }} Luxury Hotel Management System</p>
            <small>Designed with ❤️ for Better Hospitality</small>
        </div>

    </div>

</footer>