@extends('frontend.layouts.app')

    <style>
        .et_pb_section.et_pb_section_0 {
            background-image: url("{{ asset('assets/images/about/inner-banner-2.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: transparent;
            width: 100%;
        }

        .gradient-overlay .et_pb_text_inner {
            background: linear-gradient(303deg, rgba(213, 183, 119, 1) 0%, rgba(170, 116, 45, 1) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

@section('title', 'About Us - Eterna Reads')

@section('content')

<section class="main-content">
        <article id="post-12" class="post-12 page type-page status-publish hentry">
            <div class="entry-content">
                <div class="et-l et-l--post">
                    <div class="et_builder_inner_content et_pb_gutters3">

                        <!-- Banner Section -->
                        <div class="et_pb_section et_pb_section_0 et_pb_with_background et_section_regular">
                            <div class="et_pb_row">
                                <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12">
                                    <div class="et_pb_module et_pb_text gradient-overlay">
                                        <div class="et_pb_text_inner">
                                            <h1 style="text-transform: uppercase;">About American Peptides</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="et_pb_section mt-5 about-section">

                            <div class="row justify-content-center">
                                <div class="col-lg-10 col-md-12">
                                    <div class="et_pb_text_inner">
                                        <p class="">
                                            We are a leading provider of high-quality peptides for laboratories,
                                            researchers, and academic institutions across the globe. All our
                                            products are synthesized and lyophilized in the United States, with
                                            purity levels exceeding 99%+. We have a wide offering of standard
                                            peptides as well as topical peptides, peptide blends, customizable
                                            orders, and an expert team ready to assist you.
                                        </p>

                                        <h2 class="section-heading mt-5 mb-4 fw-bold">Why Choose Us?</h2>

                                        <p><strong>Top Quality:</strong> Our peptides are manufactured locally
                                            against the highest standards for synthesis, undergoing rigorous quality
                                            control measures to ensure their purity, stability, and consistency.</p>

                                        <p><strong>Range of Products:</strong> We offer a comprehensive and
                                            industry-leading peptide catalog. Whether you require standard peptides,
                                            blends, topical peptides, or customized orders, our experienced team is
                                            ready to assist you.</p>

                                        <p><strong>Expert Customer Service:</strong> We believe in building
                                            long-lasting relationships with our customers. Our dedicated customer
                                            support team is here to support you. We will do everything in our power
                                            to ensure that our customers are satisfied, even after products are
                                            delivered.</p>

                                        <p><strong>Fast and Free Delivery:</strong> We strive to provide fast and
                                            reliable delivery, no matter where you are. For orders over $200, the
                                            shipping is on us.</p>

                                        <p class="mt-4">
                                            For customized peptide inquiries or to place an order, please reach out
                                            to our customer support team by visiting our <a
                                                href="../contact-us/index.html" class="text-danger fw-bold">Contact
                                                page</a>.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </article>
    </section>

@endsection 