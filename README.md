# invisible_recaptcha
The invisible reCAPTCHA is a service that protects your site againts spam without using a challenge or a checkbox.
The Invisible reCAPTCHA module adds the challenge div in the form and binds the submit button to the invisible_recaptcha library. On form submit, in javascript, the execute function is called on the grecaptcha object and a new field (g-reptcha-response) will be populated with the response from the reCAPTCHA API. Next, based on the value of the success attribute from the response, the submitting process will continue, or an error will be set on the form, preventing it from submitting.

## Invisible recaptcha configurations
1. In order to start using invisible reCAPTCHA you need to sign up for an API key pair for your site. Go to https://www.google.com/recaptcha/intro/index.html and click on the **Get reCAPTCHA** button. If you already have an Ivisible reCAPTCHA key pair for your site go to step 2, else go in the **Register a new site** section and select the **Invisible reCAPTCHA** radio button. 
After registering the domain for your site you will get 2 keys, the site key and the secret key.
2. Now you need to go in the Configuration menu in Drupal and select **Invisible reCAPTCHA configurations** from the **INVISIBLE RECAPTCHA** tab. Here you need to set the site key and the secret key and save the configurations.

## Add invisible recaptcha on a form
1. Go in the Configuration menu in Drupal and click **Invisible reCAPTCHA checks** from the **INVISIBLE RECAPTCHA** tab.
2. Add the id of the form and click Save.
**If you want to delete a form id you need to clear the textfield and then click Save**.

