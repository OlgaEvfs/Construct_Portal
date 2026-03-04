# Construct Portal
Construct Portal is a web application designed for browsing news and vacancies, featuring a robust administrative panel for comprehensive content management.

## 📌 Version
1.0

## 📖 Description
Construct Portal is built for users seeking news and job opportunities, while providing administrators with powerful tools to manage publications.        

The application features role-based access control (RBAC):
**Guests:** Can browse news and vacancies.
**Users:** Access to registration, authorization, and profile management.
**Administrators:** Full control over news and vacancy management (CRUD).

## 🚀 Key Features
**Categorized Content:** Browse news and job openings by specific categories.
**Search Functionality:** Fast search for both news and vacancies.
**User Management:** Secure registration, login, and account settings.
**Admin Dashboard:**
Add / Edit / Delete news.
Add / Edit / Delete vacancies.
**Responsive Design:** Optimized for various devices and screen sizes.

## 🖥 System Requirements
### Operating Systems
Windows 10+
Linux
macOS

### Supported Browsers
Google Chrome
Mozilla Firefox
Microsoft Edge

### Minimum Resolution
1280 × 720

## 🌍 Supported Languages
Russian
Estonian
English (optional)

## ⚠️ Limitations
Active internet connection required.
Authorized-only access for specific features.
Admin-only access for management functions.

## 🔧 Installation and Setup
1. **Clone the repository:**
git clone https://github.com/your-username/construct-portal.git
2. **Navigate to the project folder:**
cd construct-portal
3. **Launch local server** (e.g., using OpenServer / XAMPP / Built-in server):
Access via browser: `http://localhost/ConstructPortal`

*Note: Ensure your web server and MySQL database are running.*

## 🔑 Authentication Flow
### Registration
1. Click the **Register** button.
2. Fill out the form (Name, Email, Password).
3. Confirm registration.

### Login
1. Click the **Login** button.
2. Enter your credentials (Email and Password).
3. Click **Enter**.

## 🧭 Interface Overview
### Layout Components
**Header:** Navigation, Login, and Registration links.
**Main Content:** News and vacancies feed.
**Sidebar:** Category filters.
**Footer:** Contact information.

### Navigation Menu
Home (Stardileht)
Categories (Kategooriad)
Info
Register
Search

## 🎨 Design (Figma)
[Link to Interface Prototype]

## 📰 Administrative Functions
### News Management
1. Access the Admin Panel.
2. Click **Add News**.
3. Provide Title and Content.
4. Save.

### Vacancy Management
1. Access the Admin Panel.
2. Click **Add Vacancy**.
3. Fill in details (Category, City, Salary).
4. Save.

## ❌ Error Handling
| Error | Description |
| :--- | :--- |
| **Email already exists** | The user is already registered. |
| **Invalid login or password** | Incorrect credentials. |
| **Access denied** | Insufficient permissions for the action. |

## 🔐 Security Standards
**Password Policy:** Minimum length of 6 characters.
**Data Protection:** Passwords are stored using secure encryption (hashing).
**Privacy:** Personal data is not shared with third parties.

## 📄 License
This project was developed for educational purposes. Modification and use are permitted.
