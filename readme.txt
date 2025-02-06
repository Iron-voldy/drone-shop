# 🚀 Drone E-Commerce Project
A **PHP & MySQL-based Drone Store** with features like product management, cart, wishlist, user authentication, and order processing.

---

## 📌 Features
- **User Authentication:** Register, login, and profile management.
- **Product Management:** Add, update, and remove products.
- **Cart & Wishlist:** Add/remove products, update quantities.
- **Order System:** Checkout, payments, and order tracking.
- **Responsive UI:** Bootstrap-powered, clean interface.

---

## 📁 Folder Structure
```
/dronephotography
│── assets/
│   ├── css/                # Stylesheets (Bootstrap, custom CSS)
│   ├── img/                # Images & product photos
│   ├── js/                 # JavaScript files
│── includes/
│   ├── header.php          # Navbar & main menu
│   ├── footer.php          # Footer section
│── database/
│   ├── connection.php      # Database connection
│   ├── db.sql              # MySQL database file
│── products/
│   ├── add_product.php     # Admin: Add new products
│   ├── product-details.php # Single product view
│   ├── wishlist.php        # User wishlist page
│── cart/
│   ├── cart.php            # Shopping cart
│   ├── checkout.php        # Checkout page
│   ├── process_payment.php # Payment processing
│── orders/
│   ├── orders.php          # User orders history
│── authentication/
│   ├── login.php           # User login
│   ├── register.php        # User registration
│── profile/
│   ├── profile.php         # User profile & updates
│── index.php               # Homepage
│── README.md               # Documentation
```

---

## 🛠️ Installation Guide
### 1️⃣ Prerequisites
- **XAMPP** or **WAMP** (Local PHP Server)
- **MySQL** (Database)
- **Composer** (Optional for dependencies)

### 2️⃣ Setup Database
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin/`).
2. Create a new database: **`DroneShop`**.
3. Import `database/db.sql`.

OR

Run this command in MySQL:
```sql
CREATE DATABASE DroneShop;
USE DroneShop;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(15),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE drones (
    drone_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category VARCHAR(50),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3️⃣ Configure Database Connection
Edit `database/connection.php`:
```php
class Database {
    public static $connection;

    public static function setUpConnection() {
        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "root", "", "DroneShop", "3306");
        }
    }
}
```

---

## 🔧 How to Use
### 1️⃣ Start Local Server
- Open **XAMPP** / **WAMP**.
- Start **Apache** and **MySQL**.
- Visit: [`http://localhost/dronephotography/`](http://localhost/dronephotography/).

### 2️⃣ Register & Login
1. Create a new account via `register.php`.
2. Log in to access the profile, cart, and wishlist.

### 3️⃣ Add Products (Admin)
1. Navigate to `add_product.php`.
2. Fill in product details and **upload an image**.
3. Click **"Add Product"**.

### 4️⃣ Shopping Experience
- Add products to the **cart** or **wishlist**.
- Proceed to **checkout** and make payments.
- View **order history**.

### 5️⃣ Manage Profile
- Update **username, email, phone, address**.
- View **orders, wishlist, and cart**.

---

## 📌 API Endpoints
### User Authentication
| Method | Endpoint         | Description         |
|--------|----------------|---------------------|
| `POST` | `/login.php`   | User login         |
| `POST` | `/register.php` | New user signup    |

### Product Management
| Method | Endpoint              | Description         |
|--------|----------------------|---------------------|
| `GET`  | `/product-details.php?id=1` | Get single product |
| `POST` | `/add_product.php` | Add new product    |

### Cart & Wishlist
| Method | Endpoint         | Description          |
|--------|----------------|----------------------|
| `POST` | `/add_to_cart.php` | Add item to cart  |
| `POST` | `/remove_from_cart.php` | Remove from cart |
| `POST` | `/add_to_wishlist.php` | Add to wishlist |
| `POST` | `/remove_from_wishlist.php` | Remove from wishlist |

### Orders & Checkout
| Method | Endpoint         | Description             |
|--------|----------------|-------------------------|
| `POST` | `/process_payment.php` | Process order & payment |

---

## 🛠️ Future Enhancements
✅ **Admin Panel** - Manage users, orders, and products.  
✅ **Profile Picture** - Add avatar upload.  
✅ **Payment Gateway** - Implement **PayPal / Stripe**.  
✅ **Search & Filters** - Sort products by price/category.  

---

## 📞 Support
📧 **Email:** `support@dronestore.com`  
👨‍💻 **Developed by:** `Hasindu Wanninayake`  

---

🚀 **Enjoy building your Drone Store!** Let me know if you need any modifications. ✅

