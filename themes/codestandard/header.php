<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf8>" />

    <!-- Stylesheets
	============================================= -->
    <?php wp_head(); ?>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body <?php body_class('stretched no-transition'); ?>>

    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">
        <!-- Top Bar
        ============================================= -->
        <div id="top-bar" class="dark">

            <div class="container clearfix">

                <div class="col_half nobottommargin">

                    <!-- Top Links
                    ============================================= -->
                    <div class="top-links">
                        <?php

                        if (has_nav_menu('secondary')) {
                            wp_nav_menu([
                                'theme_location'        =>  'secondary',
                                'container'             =>  false,
                                'fallback_cb'           =>  false,
                                'depth'                 =>  1,
                                // 'walker'                =>  new JU_Custom_Nav_Walker()
                            ]);
                        }

                        ?>
                    </div><!-- .top-links end -->

                </div>

                <div class="col_half fright col_last nobottommargin">

                    <!-- Top Social
                    ============================================= -->
                    <div id="top-social">
                        <ul>
                            <li><a href="#" class="si-facebook"><span class="ts-icon"><i class="icon-facebook"></i></span><span class="ts-text">Facebook</span></a></li>
                            <li><a href="#" class="si-twitter"><span class="ts-icon"><i class="icon-twitter"></i></span><span class="ts-text">Twitter</span></a></li>
                            <li><a href="#" class="si-instagram"><span class="ts-icon"><i class="icon-instagram2"></i></span><span class="ts-text">Instagram</span></a></li>
                            <li><a href="tel:+55.55.5555555" class="si-call"><span class="ts-icon"><i class="icon-call"></i></span><span class="ts-text">+55.55.5555555</span></a></li>
                            <li><a href="mailto:info@email.com" class="si-email3"><span class="ts-icon"><i class="icon-email3"></i></span><span class="ts-text">info@email.com</span></a></li>
                        </ul>
                    </div><!-- #top-social end -->

                </div>

            </div>

        </div><!-- #top-bar end -->

        <!-- Header
        ============================================= -->
        <header id="header" class="sticky-style-2">

            <div class="container clearfix">

                <!-- Logo
                ============================================= -->
                <div id="logo">
                    <a href="#" class="standard-logo">Udemy</a>
                    <a href="#" class="retina-logo">Udemy</a>
                </div><!-- #logo end -->

                <div class="top-advert">
                    <img src="images/magazine/ad.jpg">
                </div>

            </div>

            <div id="header-wrap">

                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu" class="style-2">

                    <div class="container clearfix">

                        <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                        <?php

                        if (has_nav_menu('primary')) {
                            wp_nav_menu([
                                'theme_location'        =>  'primary',
                                'container'             =>  false,
                                'fallback_cb'           =>  false,
                                'depth'                 =>  4,
                                // 'walker'                =>  new JU_Custom_Nav_Walker()
                            ]);
                        }

                        ?>

                        <!-- Top Cart
                        ============================================= -->
                        <div id="top-cart">
                            <a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>5</span></a>
                            <div class="top-cart-content">
                                <div class="top-cart-title">
                                    <h4>Shopping Cart</h4>
                                </div>
                                <div class="top-cart-items">
                                    <div class="top-cart-item clearfix">
                                        <div class="top-cart-item-image">
                                            <a href="#"><img src="images/shop/small/1.jpg" /></a>
                                        </div>
                                        <div class="top-cart-item-desc">
                                            <a href="#">Blue Round-Neck Tshirt</a>
                                            <span class="top-cart-item-price">$19.99</span>
                                            <span class="top-cart-item-quantity">x 2</span>
                                        </div>
                                    </div>
                                    <div class="top-cart-item clearfix">
                                        <div class="top-cart-item-image">
                                            <a href="#"><img src="images/shop/small/6.jpg" /></a>
                                        </div>
                                        <div class="top-cart-item-desc">
                                            <a href="#">Light Blue Denim Dress</a>
                                            <span class="top-cart-item-price">$24.99</span>
                                            <span class="top-cart-item-quantity">x 3</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="top-cart-action clearfix">
                                    <span class="fleft top-checkout-price">$114.95</span>
                                    <button class="button button-3d button-small nomargin fright">
                                        View Cart
                                    </button>
                                </div>
                            </div>
                        </div><!-- #top-cart end -->

                        <!-- Top Search
                        ============================================= -->
                        <div id="top-search">
                            <a href="#" id="top-search-trigger">
                                <i class="icon-search3"></i><i class="icon-line-cross"></i>
                            </a>
                            <form action="search.html" method="get">
                                <input type="text" name="q" class="form-control" placeholder="Type &amp; Hit Enter.." value="">
                            </form>
                        </div><!-- #top-search end -->

                    </div>

                </nav><!-- #primary-menu end -->

            </div>

        </header><!-- #header end -->