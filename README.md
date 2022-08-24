<p align="center">
  <img src="https://www.multisafepay.com/img/multisafepaylogo.svg" width="400px" position="center">
</p>

# MultiSafepay plugin for Drupal Commerce

Easily integrate MultiSafepay payment solutions into your Drupal Commerce webshop with our free plugin.

[![Latest stable version](https://img.shields.io/github/release/multisafepay/Drupal-Commerce.svg)](https://github.com/MultiSafepay/Drupal-Commerce/releases)

## About MultiSafepay

MultiSafepay is a collecting payment service provider, which means we take care of electronic contracts, technical details, and payment collection for each payment method. You can start selling online today and manage all your transactions in one place.

## Supported payment methods

See MultiSafepay Docs – [Drupal](https://docs.multisafepay.com/docs/drupal).

## Prerequisites

- You will need a [MultiSafepay account](https://testmerchant.multisafepay.com/signup). Consider a test account first.
- Drupal Commerce
- Drupal 7

## Installation and configuration

1. Unpack the content of the .ZIP file in the root of your Drupal 7 webshop.
2. Sign in to your Drupal 7 backend.
3. Go to **Site settings** > **Modules**.
4. Enable the Commerce MultiSafepay JSON module, and your selected payment method modules.
5. Click **Save configuration**.
6. Go to **Store settings** > **Advanced store settings** > **Payment methods**.
7. **Enable** the `multisafepay` core module.
8. **Enable** the modules for each payment method.
9. To configure each payment method, under Actions, click the Edit button.
10. When the main module is installed, two rules are created but disabled by default:
    - MultiSafepay order paid in full: Order state to `processing`
    This rule sets the order to `processing` when the order is paid in full.
    - MultiSafepay order complete: Shipped at MultiSafepay
    This rule updates the transaction status to Shipped at MultiSafepay. 
    For Pay After Delivery, Klarna, and E-Invoicing, this triggers the invoicing process.
 
## Support

- Create an issue on this repository. 
- Email <a href="mailto:integration@multisafepay.com">integration@multisafepay.com</a>

## Want to be part of the team?

Are you a developer interested in working at MultiSafepay? Check out our [job openings](https://www.multisafepay.com/careers/#jobopenings) and feel free to get in touch!
