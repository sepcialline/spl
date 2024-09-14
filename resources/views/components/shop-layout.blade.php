<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Specialline</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <style>
        .store-banner {
            height: 300px;
            background-color: #f8f9fa;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .store-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-container {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .logo {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            object-fit: contain;
        }

        .product-card {
            border: 1px solid #ddd;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        }

        .image-holder img {
            transition: transform 0.3s ease-in-out;
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-card:hover .image-holder img {
            transform: scale(1.1);
        }

        .swiper-pagination {
            bottom: 10px !important;
        }

        .card-detail {
            padding: 10px;
        }

        /* Cart Button Styles */
        .cart-button-fixed {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #ffd200;
            color: white;
            border-radius: 50%;
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .cart-button-fixed:hover {
            background-color: #7b7b7b;
        }

    </style>
</head>

<body>
    <section class="store-banner position-relative text-center">
        <img src="{{ asset('build/assets/img/pages/profile-banner.png') }}" alt="Store Banner" class="img-fluid">
        <div class="logo-container">
            <img src="{{ asset('build/assets/img/avatars/1.png') }}" alt="Company Logo" class="logo">
            <h4 class="text-light">Specialline Shop</h4>
        </div>
    </section>

    <div class="container mt-5 pt-5">
        <section id="mobile-products" class="product-store">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="display-7 text-dark text-uppercase text-center ">{{ __('admin.products_products_list') }}
                    </h2>
                </div>
            </div>
            <div class="swiper product-swiper my-4">
                <div class="swiper-wrapper">
                    <!-- Repeat this block for each product -->
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="image-holder">
                                <img src="https://picsum.photos/200" alt="product-item" class="img-fluid">
                            </div>
                            <div class="card-detail">
                                <h3 class="card-title text-uppercase">
                                    <a href="#">Iphone 10</a>
                                </h3>
                                <span class="item-price text-primary">$980</span>
                                <div class="cart-button mt-3">
                                    <a href="#" class="btn btn-medium btn-primary w-100">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="image-holder">
                                <img src="https://picsum.photos/seed/picsum/200" alt="product-item" class="img-fluid">
                            </div>
                            <div class="card-detail">
                                <h3 class="card-title text-uppercase">
                                    <a href="#">Iphone 10</a>
                                </h3>
                                <span class="item-price text-primary">$980</span>
                                <div class="cart-button mt-3">
                                    <a href="#" class="btn btn-medium btn-primary w-100">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="image-holder">
                                <img src="https://picsum.photos/200/300?grayscale" alt="product-item" class="img-fluid">
                            </div>
                            <div class="card-detail">
                                <h3 class="card-title text-uppercase">
                                    <a href="#">Iphone 10</a>
                                </h3>
                                <span class="item-price text-primary">$980</span>
                                <div class="cart-button mt-3">
                                    <a href="#" class="btn btn-medium btn-primary w-100">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="image-holder">
                                <img src="https://picsum.photos/200" alt="product-item" class="img-fluid">
                            </div>
                            <div class="card-detail">
                                <h3 class="card-title text-uppercase">
                                    <a href="#">Iphone 10</a>
                                </h3>
                                <span class="item-price text-primary">$980</span>
                                <div class="cart-button mt-3">
                                    <a href="#" class="btn btn-medium btn-primary w-100">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="product-card">
                            <div class="image-holder">
                                <img src="https://picsum.photos/200" alt="product-item" class="img-fluid">
                            </div>
                            <div class="card-detail">
                                <h3 class="card-title text-uppercase">
                                    <a href="#">Iphone 10</a>
                                </h3>
                                <span class="item-price text-primary">$980</span>
                                <div class="cart-button mt-3">
                                    <a href="#" class="btn btn-medium btn-primary w-100">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of product block -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
    </div>

    <footer class="mt-5 pt-5">
        <div class="container">
            <div class="row d-flex flex-wrap justify-content-between">
                <div class="col-md-4 col-sm-6">
                    <div class="copyright">
                        <p>© Copyright 2024. <a href="https://specialline.ae/">Specialline Delivery Service</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Cart Button -->
    <a href="#" class="cart-button-fixed">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
            style="fill: rgb(0, 0, 0);transform: ;msFilter:;">
            <circle cx="10.5" cy="19.5" r="1.5"></circle>
            <circle cx="17.5" cy="19.5" r="1.5"></circle>
            <path
                d="M21 7H7.334L6.18 4.23A1.995 1.995 0 0 0 4.333 3H2v2h2.334l4.743 11.385c.155.372.52.615.923.615h8c.417 0 .79-.259.937-.648l3-8A1.003 1.003 0 0 0 21 7zm-4 6h-2v2h-2v-2h-2v-2h2V9h2v2h2v2z">
            </path>
        </svg>
        <span class="position-absolute top-0 start-95 p-3 translate-middle badge rounded-pill bg-danger">
            0
        </span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.product-swiper', {
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
            },
        });
    </script>
</body>

</html>
