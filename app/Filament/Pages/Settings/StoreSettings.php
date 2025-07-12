<?php

namespace App\Filament\Pages\Settings;

use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class StoreSettings extends BaseSettings
{
    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('General')
                        ->schema([
                            Section::make('Store Information')
                                ->description('Basic information about your store.')
                                ->schema([
                                    TextInput::make('store.name')
                                        ->label('Store Name')
                                        ->required()
                                        ->helperText('The name of your ecommerce store.'),
                                    TextInput::make('store.email')
                                        ->label('Contact Email')
                                        ->email()
                                        ->helperText('Customer support or contact email.'),
                                    TextInput::make('store.phone')
                                        ->label('Contact Phone')
                                        ->helperText('Customer support phone number.'),
                                    Textarea::make('store.address')
                                        ->label('Store Address')
                                        ->helperText('Physicaimage.pngl address of your store (for invoices, shipping, etc).'),
                                    \Filament\Forms\Components\FileUpload::make('store.logo')
                                        ->label('Shop Logo')
                                        ->image()
                                        ->directory('settings/logo')
                                        ->helperText('Upload your shop logo (shown in header, emails, etc).'),
                                    TextInput::make('store.facebook')
                                        ->label('Facebook Page URL')
                                        ->helperText('Link to your Facebook page.'),
                                    TextInput::make('store.instagram')
                                        ->label('Instagram Profile URL')
                                        ->helperText('Link to your Instagram profile.'),
                                    TextInput::make('store.twitter')
                                        ->label('Twitter Profile URL')
                                        ->helperText('Link to your Twitter/X profile.'),
                                    TextInput::make('store.currency')
                                        ->label('Store Currency')
                                        ->default('USD')
                                        ->helperText('The default currency for your store (e.g., USD, EUR, GBP).'),
                                ]),
                        ]),
                    Tabs\Tab::make('SEO')
                        ->schema([
                            Section::make('SEO Information')
                                ->description('Meta tags and SEO settings for your shop.')
                                ->schema([
                                    TextInput::make('seo.meta_title')
                                        ->label('Meta Title')
                                        ->maxLength(255)
                                        ->helperText('Title for search engines and browser tabs.'),
                                    Textarea::make('seo.meta_description')
                                        ->label('Meta Description')
                                        ->maxLength(255)
                                        ->helperText('Description for search engines.'),
                                    TextInput::make('seo.meta_keywords')
                                        ->label('Meta Keywords')
                                        ->maxLength(255)
                                        ->helperText('Comma-separated keywords for SEO.'),
                                    TextInput::make('seo.google_analytics_id')
                                        ->label('Google Analytics ID')
                                        ->helperText('Your Google Analytics Measurement ID (e.g., G-XXXXXXXXXX).'),
                                    TextInput::make('seo.facebook_pixel_id')
                                        ->label('Facebook Pixel ID')
                                        ->helperText('Your Facebook Pixel ID for tracking conversions.'),
                                ]),
                        ]),
                    Tabs\Tab::make('Payments')
                        ->schema([
                            Section::make('Payment Methods')
                                ->description('Enable or disable payment methods for your store.')
                                ->schema([
                                    Toggle::make('payments.enable_stripe')
                                        ->label('Enable Stripe')
                                        ->helperText('Allow customers to pay using Stripe.'),
                                    TextInput::make('payments.stripe_key')
                                        ->label('Stripe Public Key')
                                        ->helperText('Your Stripe publishable key.'),
                                    TextInput::make('payments.stripe_secret')
                                        ->label('Stripe Secret Key')
                                        ->password()
                                        ->helperText('Your Stripe secret key.'),
                                    Toggle::make('payments.enable_paypal')
                                        ->label('Enable PayPal')
                                        ->helperText('Allow customers to pay using PayPal.'),
                                    TextInput::make('payments.paypal_client_id')
                                        ->label('PayPal Client ID')
                                        ->helperText('Your PayPal client ID.'),
                                    TextInput::make('payments.paypal_secret')
                                        ->label('PayPal Secret')
                                        ->password()
                                        ->helperText('Your PayPal secret.'),
                                ]),
                        ]),
                    Tabs\Tab::make('Mail')
                        ->schema([
                            Section::make('Mail Theme Colors')
                                ->description('Customize the colors used in your email templates.')
                                ->schema([
                                    TextInput::make('mail.primary_color')
                                        ->label('Mail Primary Color')
                                        ->default('#9B8B7A')
                                        ->helperText('Primary color for email buttons and highlights.'),
                                    TextInput::make('mail.background_color')
                                        ->label('Mail Background Color')
                                        ->default('#FAF9F7')
                                        ->helperText('Background color for emails.'),
                                    TextInput::make('mail.text_color')
                                        ->label('Mail Text Color')
                                        ->default('#4A3F35')
                                        ->helperText('Main text color for emails.'),
                                ]),
                        ]),
                ]),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Store Settings';
    }

    public function getTitle(): string
    {
        return 'Store Settings';
    }
} 