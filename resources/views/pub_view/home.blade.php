@extends('pub_view.layout.app') 
@section('title') 
Home 
@endsection 

@section('content')

@if (session()->has('error'))
<p class="mb-0 alert alert-danger text-center">{{ session()->get('error') }}</p>
@endif
@if (session()->has('success'))
<p class="mb-0 alert alert-success text-center">{{ session()->get('success') }}</p>
@endif

<!-- ======= About Section ======= -->
<section id="about" class="about section-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>About</h2>
            <h3>Find Out More <span>About Us</span></h3>
            <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                <img src="{{ asset('pv_assets/img/about.jpg') }}" class="img-fluid" alt="" />
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
                {{-- <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                <p class="fst-italic">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <ul>
                    <li>
                        <i class="bx bx-store-alt"></i>
                        <div>
                            <h5>Ullamco laboris nisi ut aliquip consequat</h5>
                            <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
                        </div>
                    </li>
                    <li>
                        <i class="bx bx-images"></i>
                        <div>
                            <h5>Magnam soluta odio exercitationem reprehenderi</h5>
                            <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi</p>
                        </div>
                    </li>
                </ul> --}}
                <p>
                    Effort E-Learning MP is a Bangladeshi trusted platform. Here you can earn from the comfort of your home by learning various courses on our platform in your spare time. 
                    Effort E-Learning MP platform is a learning and earning site. Here you can learn as well as earn. 
                    Besides learning courses on Effort E-Learning MP platform, you will get the opportunity to work on our platform, which will make you self-reliant. 
                    You can showcase your talent and build your career on Facebook, YouTube, Instagram and TikTok etc. 
                    Effort E-Learning MP is one of the platforms to make yourself self-reliant by using your free time.
                </p>
            </div>
        </div>
    </div>
</section>
<!-- End About Section -->

<!-- ======= Courses Section ======= -->
<section id="courses" class="services">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Courses</h2>
            <h3>Check our <span>Courses</span></h3>
            <p>Get admited to our courses.</p>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="owl-slide-3 owl-carousel row justify-content-center">

                    @foreach ($courses as $course)
                        <div class="course-1-item col-md-3 text-center card mx-4 my-4">
                            <figure class="thumnail">
                                <a href=""><img width="340px" src="{{ asset('storage/uploads/image/'.$course->image) }}" alt="Image" class="img-fluid" /></a>
                                <div class="price">{{ $course->price }}</div>
                                {{-- <div class="category"><h3>Diploma in Electric & Electronic Technology</h3></div> --}}
                            </figure>
                            <div class="course-1-content pb-4">
                                <h2>{{ $course->title }}</h2>
                                <div class="rating text-center mb-3">
                                    <span class="icon-star2 text-warning"></span>
                                    <span class="icon-star2 text-warning"></span>
                                    <span class="icon-star2 text-warning"></span>
                                    <span class="icon-star2 text-warning"></span>
                                    <span class="icon-star2 text-warning"></span>
                                </div>
                                <p class="desc mb-4">{{ $course->description }}</p>
                                <p><a href="" class="btn btn-primary rounded-0 px-4">See More</a></p>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                {{-- <div class="col-8 text-center col-md-8 mx-auto">
                    <a href="" class="btn btn-primary rounded-0 px-4">All Courses</a>
                </div> --}}
            </div>
        </div>

        {{-- <div class="row"> --}}
            {{-- @foreach ($courses as $course)

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><img src="{{ asset('storage/uploads/image/'.$course->image) }}" alt="icon"></div>
                        <h4><a href="">{{ $course->title }}</a></h4>
                        <p>{{ $course->description }}</p>
                    </div>
                </div>

            @endforeach --}}
            
            {{-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-file"></i></div>
                    <h4><a href="">Sed ut perspiciatis</a></h4>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-tachometer"></i></div>
                    <h4><a href="">Magni Dolores</a></h4>
                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-world"></i></div>
                    <h4><a href="">Nemo Enim</a></h4>
                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-slideshow"></i></div>
                    <h4><a href="">Dele cardo</a></h4>
                    <p>Quis consequatur saepe eligendi voluptatem consequatur dolor consequuntur</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box">
                    <div class="icon"><i class="bx bx-arch"></i></div>
                    <h4><a href="">Divera don</a></h4>
                    <p>Modi nostrum vel laborum. Porro fugit error sit minus sapiente sit aspernatur</p>
                </div>
            </div> --}}
        {{-- </div> --}}
    </div>
</section>
<!-- End Services Section -->

<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Contact</h2>
            <h3><span>Contact Us</span></h3>
            <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-6">
                <div class="info-box mb-4">
                    <i class="bx bx-map"></i>
                    <h3>Our Address</h3>
                    <p>Sunamganj, Sylhet, Bangladesh</p>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="info-box mb-4">
                    <i class="bx bx-envelope"></i>
                    <h3>Email Us</h3>
                    <p><a href="mailto:mpeffortelearning@gmail.com">mpeffortelearning@gmail.com</a></p>
                </div>
            </div>

            {{--
            <div class="col-lg-3 col-md-6">
                <div class="info-box mb-4">
                    <i class="bx bx-phone-call"></i>
                    <h3>Call Us</h3>
                    <p>+1 5589 55488 55</p>
                </div>
            </div>
            --}}
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-6">
                <iframe
                    class="mb-4 mb-lg-0"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14455.775104869597!2d91.39363290114608!3d25.069894694686667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3750daf49ba21823%3A0x3180c8d4ddeb5b9b!2sSunamganj%2C%20Bangladesh!5e0!3m2!1sen!2sus!4v1715844689764!5m2!1sen!2sus"
                    frameborder="0"
                    style="border: 0; width: 100%; height: 384px;"
                    allowfullscreen
                ></iframe>
            </div>

            <div class="col-lg-6">
                <form action="{{ route('contact_us') }}" method="post" role="form" class="php-email-form">
                    @csrf
                    <div class="row">
                        <div class="col form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required />
                            @error('name')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required />
                            @error('email')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required />
                        @error('subject')
                        <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                        @error('message')
                        <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="my-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Section -->

@endsection



