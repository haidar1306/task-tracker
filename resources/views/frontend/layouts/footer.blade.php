<footer class="footer">

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-4 col-md-6">
                <h4>Luxury Hotel</h4>
                <p>
                    Experience luxury hospitality, premium rooms and
                    world class service crafted for unforgettable stays.
                </p>
                <div class="footer-social">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h4>Quick Links</h4>
                <ul class="list-unstyled">
                    <li><a href="{{ route('frontend.index') }}">Home</a></li>
                    <li><a href="{{ route('frontend.room.index') }}">Rooms</a></li>
                    <li><a href="{{ route('frontend.gallery') }}">Gallery</a></li>
                    <li><a href="{{ route('frontend.contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h4>Customer</h4>
                <ul class="list-unstyled">
                    <li><a href="{{ route('frontend.reservation.index') }}">My Bookings</a></li>
                    <li><a href="#">Payments</a></li>
                    <li><a href="{{ route('frontend.user.account') }}">Profile</a></li>
                    <li><a href="{{ route('frontend.auth.logout') }}">Logout</a></li>