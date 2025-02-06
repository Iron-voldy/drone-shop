# Drone E-Commerce Platform

## Project Overview
This is a fully functional **Drone E-Commerce Platform** built using PHP, MySQL, JavaScript, and Bootstrap. Users can browse, add products to the cart and wishlist, manage their profile, place orders, and process payments.

---

## Features

### **User Features**
- User Registration & Login
- View and Update Profile Information
- Add Products to Wishlist
- Manage Cart (Update Quantity, Remove Items)
- Checkout and Payment Processing
- View Order History

### **Admin Features**
- Add, Update, and Delete Products
- Manage Orders & Payments

### **E-Commerce Functionalities**
- Product Listing with Details
- Add to Wishlist & Remove from Wishlist
- Shopping Cart with Quantity Updates
- Order Management System
- Payment Processing
- Secure Authentication & Session Handling

---

## Installation
### **1. Clone the Repository**
```sh
 git clone https://github.com/your-repo/drone-ecommerce.git
```

### **2. Setup Database**
- Import the `drone_shop.sql` file into MySQL.
- Database Name: `DroneShop`

### **3. Configure Database Connection**
Edit `connection.php` and update your database credentials:
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

### **4. Start the Server**
Use XAMPP or any local server and navigate to the project folder.

```sh
php -S localhost:8000
```
Then, open `http://localhost:8000/` in the browser.

---

## File Structure
```
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
├── includes/
│   ├── header.php
│   ├── footer.php
├── database/
│   ├── connection.php
├── pages/
│   ├── index.php (Home Page)
│   ├── product-details.php
│   ├── profile.php
│   ├── cart.php
│   ├── wishlist.php
│   ├── checkout.php
│   ├── add_product.php
├── order_success.php
├── README.txt
```

---

## Usage Instructions
### **1. Register and Login**
- Go to `register.php` to create an account.
- Log in using `login.php`.

### **2. Manage Profile**
- Click on "Profile" to update user details.

### **3. Browse and Buy Products**
- Add products to the cart.
- View wishlist and move items to the cart.
- Proceed to checkout and complete payment.

### **4. Manage Orders**
- Track orders and view order history.

---

## Sample Data
To test the project, use the following sample data:
```sql
INSERT INTO users (username, email, password_hash, full_name, phone, address) VALUES ('testuser', 'test@example.com', 'password123', 'Test User', '1234567890', '123 Test Street');

INSERT INTO drones (name, description, price, stock, category, image_url) VALUES
('DJI Mavic Air 2', 'Advanced drone with 4K camera and 34-min flight time.', 899.99, 10, 'Photography', 'assets/img/gallery/drone1.png');
```

---

## Technologies Used
- **Backend:** PHP, MySQL
- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Database:** MySQL
- **Libraries:** jQuery, FontAwesome

---

## License
This project is licensed under the MIT License.

---

## Contact
For support or contributions, contact:
**Your Name**
- Email: your.email@example.com
- GitHub: [your-github](https://github.com/your-github)

