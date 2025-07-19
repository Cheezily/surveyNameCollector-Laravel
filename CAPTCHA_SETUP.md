# reCAPTCHA Setup Instructions

## Overview
A Google reCAPTCHA has been added to the registration form to prevent spam and bot registrations.

## Setup Steps

### 1. Get Google reCAPTCHA Keys
1. Go to [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin)
2. Click "Create" to add a new site
3. Choose reCAPTCHA v2 ("I'm not a robot" checkbox)
4. Add your domain(s):
   - For local development: `localhost` or `127.0.0.1`
   - For production: your actual domain name
5. Accept the terms and click "Submit"
6. Copy the **Site Key** and **Secret Key**

### 2. Configure Environment Variables
Add the following to your `.env` file:

```env
# Google reCAPTCHA
NOCAPTCHA_SITEKEY=your_site_key_here
NOCAPTCHA_SECRET=your_secret_key_here
```

Replace `your_site_key_here` and `your_secret_key_here` with the actual keys from Google.

### 3. Test the Implementation
1. Start your Laravel server: `php artisan serve`
2. Navigate to `/register`
3. You should see the reCAPTCHA checkbox
4. Try submitting the form without completing the captcha - it should show an error
5. Complete the captcha and submit - registration should work normally

## Files Modified
- `app/Http/Controllers/Auth/RegisterController.php` - Added captcha validation
- `resources/views/auth/register.blade.php` - Added reCAPTCHA widget
- `composer.json` - Added `anhskohbo/no-captcha` package
- `.env` - Added reCAPTCHA configuration variables

## Troubleshooting
- Make sure your domain is correctly configured in Google reCAPTCHA admin
- For localhost testing, ensure you've added `localhost` as an allowed domain
- Check that your `.env` keys are correct and have no extra spaces
- Clear your config cache: `php artisan config:clear`

## Security Notes
- Never commit your secret keys to version control
- Use different keys for development and production environments
- Regularly rotate your keys if needed 