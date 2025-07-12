@extends('frontend.layouts.app')

@section('title', 'FAQ - Eterna Reads')

@section('content')
<!-- Page Header -->
<section class="page-header py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="text-white display-4 fw-bold mb-3">Frequently Asked Questions</h1>
                <p class="text-white lead mb-0">Find answers to common questions about our services and policies</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Navigation -->
<section class="faq-nav py-4" style="background: var(--light-bg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <a href="#ordering" class="btn btn-outline-primary btn-sm">Ordering</a>
                    <a href="#shipping" class="btn btn-outline-primary btn-sm">Shipping & Delivery</a>
                    <a href="#returns" class="btn btn-outline-primary btn-sm">Returns & Refunds</a>
                    <a href="#payment" class="btn btn-outline-primary btn-sm">Payment</a>
                    <a href="#products" class="btn btn-outline-primary btn-sm">Products</a>
                    <a href="#account" class="btn btn-outline-primary btn-sm">Account</a>
                    <a href="#privacy" class="btn btn-outline-primary btn-sm">Privacy Policy</a>
                    <a href="#terms" class="btn btn-outline-primary btn-sm">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content -->
<section class="faq-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- Ordering Section -->
                <div id="ordering" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-cart-check me-2" style="color: var(--primary-color);"></i>
                        Ordering
                    </h2>
                    
                    <div class="accordion" id="orderingAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ordering1">
                                    How do I place an order?
                                </button>
                            </h3>
                            <div id="ordering1" class="accordion-collapse collapse show" data-bs-parent="#orderingAccordion">
                                <div class="accordion-body">
                                    <p>Placing an order is easy! Simply browse our collection, add items to your cart, and proceed to checkout. You'll need to create an account or sign in, provide your shipping and billing information, and complete your payment.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ordering2">
                                    Can I modify or cancel my order?
                                </button>
                            </h3>
                            <div id="ordering2" class="accordion-collapse collapse" data-bs-parent="#orderingAccordion">
                                <div class="accordion-body">
                                    <p>You can modify or cancel your order within 1 hour of placing it by contacting our customer service team. Once your order has been processed and shipped, modifications may not be possible.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ordering3">
                                    Do you offer gift wrapping?
                                </button>
                            </h3>
                            <div id="ordering3" class="accordion-collapse collapse" data-bs-parent="#orderingAccordion">
                                <div class="accordion-body">
                                    <p>Yes! We offer beautiful gift wrapping for an additional $5. You can select this option during checkout. Our gift boxes are also perfect for special occasions and come beautifully packaged.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Section -->
                <div id="shipping" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-truck me-2" style="color: var(--secondary-color);"></i>
                        Shipping & Delivery
                    </h2>
                    
                    <div class="accordion" id="shippingAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#shipping1">
                                    How long does shipping take?
                                </button>
                            </h3>
                            <div id="shipping1" class="accordion-collapse collapse show" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <p>Standard shipping typically takes 3-5 business days within the continental US. Express shipping (1-2 business days) is available for an additional fee. International shipping times vary by location.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping2">
                                    How much does shipping cost?
                                </button>
                            </h3>
                            <div id="shipping2" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <p>Standard shipping is free for orders over $50. For orders under $50, standard shipping is $5.99. Express shipping is available for $12.99. International shipping rates vary by location.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping3">
                                    How do I track my order?
                                </button>
                            </h3>
                            <div id="shipping3" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <p>Once your order ships, you'll receive a tracking number via email. You can also track your order by logging into your account and visiting the "My Orders" section.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping4">
                                    Do you ship internationally?
                                </button>
                            </h3>
                            <div id="shipping4" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <p>Yes, we ship to most countries worldwide. International shipping rates and delivery times vary by location. Some restrictions may apply to certain products.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Returns Section -->
                <div id="returns" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-arrow-return-left me-2" style="color: var(--success-color);"></i>
                        Returns & Refunds
                    </h2>
                    
                    <div class="accordion" id="returnsAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#returns1">
                                    What's your return policy?
                                </button>
                            </h3>
                            <div id="returns1" class="accordion-collapse collapse show" data-bs-parent="#returnsAccordion">
                                <div class="accordion-body">
                                    <p>We accept returns within 30 days of delivery for books in their original condition. Digital products (audiobooks) are non-refundable once downloaded. Gift boxes can be returned if unopened and in original packaging.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#returns2">
                                    How do I return an item?
                                </button>
                            </h3>
                            <div id="returns2" class="accordion-collapse collapse" data-bs-parent="#returnsAccordion">
                                <div class="accordion-body">
                                    <p>To return an item, log into your account and go to "My Orders." Select the order containing the item you want to return and follow the return process. You'll receive a return label to print and attach to your package.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#returns3">
                                    When will I receive my refund?
                                </button>
                            </h3>
                            <div id="returns3" class="accordion-collapse collapse" data-bs-parent="#returnsAccordion">
                                <div class="accordion-body">
                                    <p>Once we receive your return, we'll process it within 3-5 business days. Refunds are typically issued to your original payment method within 5-10 business days, depending on your bank or credit card company.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div id="payment" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-credit-card me-2" style="color: var(--info-color);"></i>
                        Payment
                    </h2>
                    
                    <div class="accordion" id="paymentAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#payment1">
                                    What payment methods do you accept?
                                </button>
                            </h3>
                            <div id="payment1" class="accordion-collapse collapse show" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p>We accept all major credit cards (Visa, MasterCard, American Express, Discover), PayPal, and Apple Pay. All payments are processed securely through our payment partners.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment2">
                                    Is my payment information secure?
                                </button>
                            </h3>
                            <div id="payment2" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p>Yes, your payment information is secure. We use industry-standard SSL encryption and never store your credit card information on our servers. All payments are processed through secure, PCI-compliant payment gateways.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment3">
                                    Do you offer payment plans?
                                </button>
                            </h3>
                            <div id="payment3" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p>Currently, we don't offer payment plans, but we do accept PayPal which may offer its own payment options. We also frequently run promotions and discounts that can help make your purchase more affordable.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div id="products" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-book me-2" style="color: var(--warning-color);"></i>
                        Products
                    </h2>
                    
                    <div class="accordion" id="productsAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#products1">
                                    What types of books do you carry?
                                </button>
                            </h3>
                            <div id="products1" class="accordion-collapse collapse show" data-bs-parent="#productsAccordion">
                                <div class="accordion-body">
                                    <p>We carry a wide variety of books across all genres including fiction, non-fiction, children's books, academic texts, and more. Our collection is carefully curated to ensure quality and relevance for our readers.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#products2">
                                    How do your gift boxes work?
                                </button>
                            </h3>
                            <div id="products2" class="accordion-collapse collapse" data-bs-parent="#productsAccordion">
                                <div class="accordion-body">
                                    <p>Our gift boxes are thoughtfully curated collections that include a book, related accessories, and sometimes additional items like bookmarks, candles, or tea. They're perfect for any book lover and make excellent gifts.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#products3">
                                    Can I get book recommendations?
                                </button>
                            </h3>
                            <div id="products3" class="accordion-collapse collapse" data-bs-parent="#productsAccordion">
                                <div class="accordion-body">
                                    <p>Absolutely! Our team loves helping readers find their next favorite book. You can contact us through our contact form, call us, or visit our blog for regular book recommendations and reviews.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Section -->
                <div id="account" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-person me-2" style="color: var(--danger-color);"></i>
                        Account
                    </h2>
                    
                    <div class="accordion" id="accountAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#account1">
                                    How do I create an account?
                                </button>
                            </h3>
                            <div id="account1" class="accordion-collapse collapse show" data-bs-parent="#accountAccordion">
                                <div class="accordion-body">
                                    <p>Creating an account is easy! Click the "Register" link in the top navigation, fill out the form with your information, and you'll be ready to start shopping. You can also create an account during checkout.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#account2">
                                    How do I reset my password?
                                </button>
                            </h3>
                            <div id="account2" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                                <div class="accordion-body">
                                    <p>If you've forgotten your password, click the "Forgot Password" link on the login page. Enter your email address, and we'll send you a link to reset your password.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#account3">
                                    Can I save my payment information?
                                </button>
                            </h3>
                            <div id="account3" class="accordion-collapse collapse" data-bs-parent="#accountAccordion">
                                <div class="accordion-body">
                                    <p>For security reasons, we don't store your credit card information on our servers. However, you can save your shipping addresses and other account information for faster checkout.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privacy Policy Section -->
                <div id="privacy" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-shield-check me-2" style="color: var(--primary-color);"></i>
                        Privacy Policy
                    </h2>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 mb-3">Information We Collect</h3>
                            <p class="mb-3">We collect information you provide directly to us, such as when you create an account, place an order, or contact us. This may include your name, email address, shipping address, and payment information.</p>
                            
                            <h3 class="h5 mb-3">How We Use Your Information</h3>
                            <p class="mb-3">We use the information we collect to process your orders, communicate with you about your orders, send you marketing materials (with your consent), and improve our services.</p>
                            
                            <h3 class="h5 mb-3">Information Sharing</h3>
                            <p class="mb-3">We do not sell, trade, or otherwise transfer your personal information to third parties except as described in our privacy policy or with your consent.</p>
                            
                            <h3 class="h5 mb-3">Data Security</h3>
                            <p class="mb-3">We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                            
                            <h3 class="h5 mb-3">Your Rights</h3>
                            <p class="mb-0">You have the right to access, update, or delete your personal information. You can also opt out of marketing communications at any time.</p>
                        </div>
                    </div>
                </div>

                <!-- Terms of Service Section -->
                <div id="terms" class="faq-section mb-5">
                    <h2 class="section-title mb-4">
                        <i class="bi bi-file-text me-2" style="color: var(--secondary-color);"></i>
                        Terms of Service
                    </h2>
                    
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 mb-3">Acceptance of Terms</h3>
                            <p class="mb-3">By accessing and using our website, you accept and agree to be bound by the terms and provision of this agreement.</p>
                            
                            <h3 class="h5 mb-3">Use License</h3>
                            <p class="mb-3">Permission is granted to temporarily download one copy of the materials on Eterna Reads's website for personal, non-commercial transitory viewing only.</p>
                            
                            <h3 class="h5 mb-3">Disclaimer</h3>
                            <p class="mb-3">The materials on Eterna Reads's website are provided on an 'as is' basis. Eterna Reads makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.</p>
                            
                            <h3 class="h5 mb-3">Limitations</h3>
                            <p class="mb-3">In no event shall Eterna Reads or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Eterna Reads's website.</p>
                            
                            <h3 class="h5 mb-3">Revisions and Errata</h3>
                            <p class="mb-0">The materials appearing on Eterna Reads's website could include technical, typographical, or photographic errors. Eterna Reads does not warrant that any of the materials on its website are accurate, complete or current.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="contact-support py-5" style="background: var(--light-bg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="section-title mb-3">Still Have Questions?</h2>
                <p class="section-subtitle mb-4">Our customer service team is here to help you find the answers you need.</p>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="support-option">
                            <i class="bi bi-envelope-fill fs-1 mb-3" style="color: var(--primary-color);"></i>
                            <h4 class="h5 mb-2">Email Us</h4>
                            <p class="text-muted small mb-2">Get a response within 24 hours</p>
                            <a href="mailto:support@eternareads.com" class="btn btn-outline-primary btn-sm">Send Email</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="support-option">
                            <i class="bi bi-telephone-fill fs-1 mb-3" style="color: var(--secondary-color);"></i>
                            <h4 class="h5 mb-2">Call Us</h4>
                            <p class="text-muted small mb-2">Speak with our team directly</p>
                            <a href="tel:+15551234567" class="btn btn-outline-primary btn-sm">Call Now</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="support-option">
                            <i class="bi bi-chat-fill fs-1 mb-3" style="color: var(--success-color);"></i>
                            <h4 class="h5 mb-2">Live Chat</h4>
                            <p class="text-muted small mb-2">Chat with us in real-time</p>
                            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-sm">Start Chat</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 