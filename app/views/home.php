<?php
require_once 'app/views/header.php';
?>


<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallary">Proyectos</a>
                </li>
               
            </ul>
            <a class="navbar-brand m-auto" href="#">
                <img src="assets/imgs/logo sun obra.png     " class="brand-img" alt="">
                <span class="brand-txt">S U N O B R A</span>
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#blog">Redes<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testmonial">Mas info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="/login" class="btn btn-primary ml-xl-4">Iniciar sesión</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- header -->
    <header id="home" class="header">
        <div class="overlay text-white text-center">
            <h1 class="display-2 font-weight-bold my-3">S U N O B R A</h1>
            <h2 class="display-4 mb-5">  Construyelo con tus manos</h2>
            <a class="btn btn-lg btn-primary" href="#gallary">AVANCEMOS JUNTOS </a>
        </div>
    </header>

    <!--  nosotros-->
    <div id="about" class="container-fluid wow fadeIn" id="about"data-wow-duration="1.5s">
        <div class="row">
            <div class="col-lg-6 has-img-bg"></div>
            <div class="col-lg-6">
                <div class="row justify-content-center">
                    <div class="col-sm-8 py-5 my-5">
                        <h2 class="mb-4">Nosotros </h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur, quisquam accusantium nostrum modi, nemo, officia veritatis ipsum facere maxime assumenda voluptatum enim! Labore maiores placeat impedit, vero sed est voluptas!Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita alias dicta autem, maiores doloremque quo perferendis, ut obcaecati harum, <br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum necessitatibus iste,
                        nulla recusandae porro minus nemo eaque cum repudiandae quidem voluptate magnam voluptatum? <br>Nobis, saepe sapiente omnis qui eligendi pariatur. quis voluptas. Assumenda facere adipisci quaerat. Illum doloremque quae omnis vitae.</p>
                        <p><b>Lonsectetur adipisicing elit. Blanditiis aspernatur, ratione dolore vero asperiores explicabo.</b></p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos ab itaque modi, reprehenderit fugit soluta, molestias optio repellat incidunt iure sed deserunt nemo magnam rem explicabo vitae. Cum, nostrum, quidem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  IMAGENES GALERIA  -->
    <div id="gallary" class="text-center bg-dark text-light has-height-md middle-items wow fadeIn">
        <h2 class="section-title">PROYECTOS</h2>
    </div>
    <div class="gallary row">
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-1.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-2.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-3.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-1.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-2.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-3.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-1.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-2.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-3.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-1.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-2.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
        <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
            <img src="assets/imgs/gallary-3.jpg" alt="template by DevCRID http://www.devcrud.com/" class="gallary-img">
            <a href="#" class="gallary-overlay">
                <i class="gallary-icon ti-plus"></i>
            </a>
        </div>
    </div>


    <!-- BLOG Section  -->
    <div id="blog" class="container-fluid bg-dark text-light py-5 text-center wow fadeIn">
        <h2 class="section-title py-5">REDES SOCIALES </h2>
        <div class="row justify-content-center">
            <div class="col-sm-7 col-md-4 mb-5">
                <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#foods" role="tab" aria-controls="pills-home" aria-selected="true">Propetarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#juices" role="tab" aria-controls="pills-profile" aria-selected="false">Empresa</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="foods" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-transparent border my-3 my-md-0">
                            <img src="assets/imgs/gallary-1.jpg" alt="template by DevCRID http://www.devcrud.com/" class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                               
                                <h4 class="pt20 pb20">David Torres </h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-transparent border my-3 my-md-0">
                            <img src="assets/imgs/gallary-2.jpg" alt="template by DevCRID http://www.devcrud.com/" class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                               
                                <h4 class="pt20 pb20">Felipe Bermudez</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-transparent border my-3 my-md-0">
                            <img src="assets/imgs/gallary-3.jpg" alt="template by DevCRID http://www.devcrud.com/" class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                         
                                <h4 class="pt20 pb20">Dilan Ruiz</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="juices" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="row">
                    <div class="col-md-4 my-3 my-md-0">
                        <div class="card bg-transparent border">
                            <img src="assets/imgs/gallary-1.jpg" alt="template by DevCRID http://www.devcrud.com/" class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">logo</a></h1>
                                <h4 class="pt20 pb20">instagram </h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 my-3 my-md-0">
                        <div class="card bg-transparent border">
                            <img src="assets/imgs/gallary-2.jpg" alt="template by DevCRID http://www.devcrud.com/" class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">logo</a></h1>
                                <h4 class="pt20 pb20">facebook</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 my-3 my-md-0">
                        <div class="card bg-transparent border">
                            <img src="assets/imgs/gallary-3.jpg" alt="template by DevCRID http://www.devcrud.com/" class="rounded-0 card-img-top mg-responsive">
                            <div class="card-body">
                                <h1 class="text-center mb-4"><a href="#" class="badge badge-primary">logo</a></h1>
                                <h4 class="pt20 pb20">x</h4>
                                <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa provident illum officiis fugit laudantium voluptatem sit iste delectus qui ex. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REVIEWS Section  -->
    <div id="testmonial" class="container-fluid wow fadeIn bg-dark text-light has-height-lg middle-items">
        <h2 class="section-title my-5 text-center">Propetarios</h2>
        <div class="row mt-3 mb-5">
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">Felipe Bermudez</h3>
                    <h6 class="testmonial-subtitle">eeeeeeee</h6>
                    <div class="testmonial-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum nobis eligendi, quaerat accusamus ipsum sequi dignissimos consequuntur blanditiis natus. Aperiam!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">David Torres</h3>
                    <h6 class="testmonial-subtitle">eeee</h6>
                    <div class="testmonial-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum minus obcaecati cum eligendi perferendis magni dolorum ipsum magnam, sunt reiciendis natus. Aperiam!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 my-3 my-md-0">
                <div class="testmonial-card">
                    <h3 class="testmonial-title">Dilan Ruiz</h3>
                    <h6 class="testmonial-subtitle">eeeer</h6>
                    <div class="testmonial-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, nam. Earum nobis eligendi, dignissimos consequuntur blanditiis natus. Aperiam!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTACT Section  -->
    <div id="contact" class="container-fluid bg-dark text-light border-top wow fadeIn">
        <div class="row">   
            <div class="col-md-6 px-0">
                <div id="map" style="width: 100%; height: 100%; min-height: 400px"></div>
            </div>
            <div class="col-md-6 px-5 has-height-lg middle-items">
                <h3>ESTAMOS UBICADOS </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, laboriosam doloremque odio delectus, sunt magnam laborum impedit molestiae, magni quae ipsum, ullam eos! Alias suscipit impedit et, adipisci illo quam.</p>
                <div class="text-muted">
                    <p><span class="ti-location-pin pr-3"></span> Bogota Colombia </p>
                    <p><span class="ti-support pr-3"></span> 3138385779</p>
                    <p><span class="ti-email pr-3"></span>sunobra69@gmail.com</p>
                </div>
            </div>
        </div>
    </div>


<?php
require_once 'app/views/footer.php';
?>