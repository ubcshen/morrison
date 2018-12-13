=== Contact Form 7 Image Captcha ===
Contributors: KTC_88
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6ZBN6VSE6UM4A
Tags: contact form 7, spam, captcha
Requires at least: 4.6
Tested up to: 4.9.9
Stable tag: 4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a clean image captcha to Contact Form 7

== Description ==

Adds an image captcha to your contact form 7 forms by adding the shortcode [cf7ic] to the form editor where you want the captcha to appear.

NEW! 
You can now hide the CAPTCHA until a user interacts with the form, simply add "toggle" to the shortcode.
[cf7ic "toggle"]

Looking for a version for Gravity forms?
We just finsished creating the **<a href="http://kccomputing.net/downloads/gravity-forms-image-captcha/" target="_blank">Gravity Forms Image Captcha</a>** which is only available at our <a href="http://kccomputing.net/store/" target="_blank">online store</a>.

= Demo =
Check out our <a href="http://kccomputing.net/contact-me/" target="_blank">live demo</a>.

= Supported Languages =
* Bulgarian    (Thanks Plamen Petkov)
* French       (Thanks deuns26)
* German       (Thanks  Te-Punkt & bkmh)
* Italian      (Thanks Mauro Giuliani)
* Persian      (Thanks Ava Darabi)
* Spanish (ES) (Thanks Erick Carbo)
* Spanish (MX)

= Like what you see? =
Please take the time to leave a review **OR** check some of our other plugins like our <a href="https://wordpress.org/plugins/wp-login-image-captcha/">WP Login Image Captcha</a>

= Go Pro! =
Want more control?
Check out our <a href="http://kccomputing.net/downloads/contact-form-7-image-captcha-pro/">pro version</a> which gives you full control over the look and feel of the image captcha.

* GDPR compliant
* Select which icons you wish to use
* Add additional icons from Font Awesome
* Customize the icon titles
* Change the captcha message
* Change the box color and border
* Change font and icon color and size independently
* Change the selected icon appearance
* Change where the icons appear
* Change the box from full width to content width

<a href="http://kccomputing.net/downloads/contact-form-7-image-captcha-pro/">Go Pro!</a>

== Installation ==

1. Upload contents to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `[cf7ic]` to your contact form 7 forms

== Frequently Asked Questions ==

= How do you add the image captcha to the forms? =

Simply add this shortcode `[cf7ic]` to your contact form

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. Pro version settings page

== Changelog ==

= 2.4.1 =
* Fixed PHP notice "Undefined offset: 0"
* Fixed PHP notice for another deprecated tag

= 2.4 =
* Added the ability to hide the CAPTCHA until the user interacts with the form, simply add "toggle" to the shortcode: [cf7ic "toggle"]
* Fixed deprecation notice “wpcf7_add_shortcode is deprecated since Contact Form 7 version 4.6! Use wpcf7_add_form_tag instead.”

= 2.3 =
* Updated FontAwesome library to version 4.7
* Fixed use of depricated wpcf7_add_shortcode in favor or wpcf7_add_form_tag function
* Added new toggle attribute (optional) [cf7ic "toggle"] which hides CAPTCHA until user interacts with the form

= 2.3 =
* Added code that allows me to add custom update messages in preparation for a future release that will make this plugin require Contact Form 7 version 4.6 to run due to CF7 making WPCF7_Shortcode and wpcf7_add_shortcode() deprecated, the replacement function and class are not supported by older versions of CF7.
* Updated text domain to meet new requirements for internationalization

= 2.2 =
* Removed unnecessary code that checked if image captcha existed in the Form
* Added Italian translation (Thanks Mauro Giuliani)
* Added Persian translation (Thanks Ava Darabi)
* Added Spanish (ES) translation (Thanks Erick Carbo)

= 2.1 =
* Added a tag generator button to the contact form 7 form controls so you do not have to manually type in the shortcode into the form. The pro version will eventually include the image captcha styling options.

= 2.0 =
* Refactored code
* Improved method to include style sheet so its only included when plugin is in use.
* Fixed validation message, you will now see "Please select an icon." when icon is not selected on submit and "Please select the correct icon." when the wrong icon was selected on submit.

= 1.5 =
* Added Spanish (MX) translation

= 1.4 =
* Updated German translation (Thanks bkmh)
* Added pro plugin details and link

= 1.3 =
* Added Bulgarian translation (Thanks Plamen Petkov)

= 1.2 =
* Improved German translation (Thanks Te-Punkt)

= 1.1 =
* Updated files and folder name
* Added German translation
* Added French translation (Thanks deuns26)

= 1.0 =
* Initial Release
