# CodeFund

CodeFund is a virtual wallet application designed to manage user wallets, transfer funds, create payment links, and more. It offers separate functionalities for Admin and User roles, along with a robust API system to interact with wallets and transactions programmatically.

## Table of Contents

- [Getting Started](#getting-started)
- [Admin Functionalities](#admin-functionalities)
- [User Functionalities](#user-functionalities)
- [API Usage](#api-usage)

---

### Getting Started

To set up CodeFund locally, follow these steps:

1. Clone the repository:
    ```bash
    git clone <repository-url>
    ```
2. Install dependencies:
    ```bash
    composer update
    ```
3. Copy the example environment file and generate a new application key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4. Start the development server:
    ```bash
    php artisan serve
    ```

5. **Optional:** To change the application name, edit `appInfo.php` in the `app/helpers` directory.

---

### Admin Functionalities

As an Admin, you can:

- **View All Users:** Access the list of all registered users.
- **Approve or Deny User Status:** Manage user access by approving or denying their account status.
- **View Wallet Balances:** Check each user’s wallet balance and see the number of API keys they’ve generated.
- **Create and Manage Deposits:** Deposit funds to user accounts using a unique `ref_id` and `secret_code`, which the user can add to their funds. View all created deposits.
- **View Profile:** Access and update your profile details.
- **Logout:** End your session securely.

---

### User Functionalities

As a User, you can:

1. **Create Wallet Account:** Set up a wallet account to enable other actions by visiting your profile and clicking "Create Account."
2. **Add Funds:** Add funds to your wallet using the `ref_id`, `amount`, and `secret_code` provided by the Admin.
3. **Transfer Funds:** Send funds to other user accounts.
4. **Generate Payment Links:** Create payment links by specifying an amount and account number, which you can share with others. You can also view and pay existing payment links in the "Payment Link > All Links" section.
5. **Manage API Access:** Create APIs with options to limit requests (up to 25,000 per minute or unlimited) and add an additional security header with `secure_header` keys. Track all created APIs and manage permissions for specific tasks.
6. **View Profile:** Access and update your profile details.
7. **Logout:** End your session securely.

---

### API Usage

To interact with CodeFund programmatically, use the available API endpoints. Follow these steps:

1. **Authentication:** Generate an auth token using the `auth` API endpoint. This token (`auth_key`) is required in each request header.
2. **API Key Usage:** Use the API key (`token_key`) from the API Manager. If the API requires additional security, include the (`security_header`).

#### Available Actions

- **check-balance**: Check the wallet balance.
- **get-transactions**: Retrieve transaction history.
- **find-user**: Look up user information.
- **send-funds**: Transfer funds to another user.
- **my-profile**: Access your profile information.
- **find-transaction**: Find a specific transaction.
- **generate-payment-link**: Create a payment link.

---

Enjoy using CodeFund!
