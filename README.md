
# 📄 **BLOG**

A **secure, responsive, and dependency-free** blog application built with **vanilla technologies**. Supports Markdown editing, featured images, and user authentication — all without frameworks.

[![Live Demo](https://img.shields.io/badge/demo-live-2ea44f?style=flat-square)]([https://itmuom.page.gd](https://dewmi.infinityfree.me/login.html))  
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com)

---

##  Features

-  **Markdown Editor**: Write with SimpleMDE (bold, code, lists, tables)
-  **Featured Images**: Upload JPG/PNG/WebP for posts
-  **Secure Auth**: `password_hash()`, prepared statements, XSS sanitization
-  **Fully Responsive**: Mobile-first design
-  **Zero Frameworks**: Pure HTML/CSS/JS + PHP/MySQL
-  **Hosting Ready**: Works on XAMPP → InfinityFree

---

##  Tech Stack

| Layer | Technology |
|-------|------------|
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Markdown** | [SimpleMDE](https://simplemde.com) (editor), [Marked.js](https://marked.js.org) (rendering) |
| **Backend** | PHP 8.0 (procedural, no frameworks) |
| **Database** | MySQL 5.7 |
| **Styling** | CSS Variables, Flexbox, Grid |
| **Hosting** | XAMPP (local), InfinityFree (production) |

---

##  Project Structure

```
/
├── backend/
│   ├── config/db.php          # DB connection + session init
│   ├── includes/auth.php      # Auth helpers
│   └── api/                   # REST-like endpoints
│       ├── auth/              # login, register, logout
│       └── posts/             # CRUD operations
├── css/
│   └── style.css              # Unified light/dark theme
├── js/
│   ├── main.js                # Core utilities
│   └── theme.js              
├── lib/
│   ├── simplemde.min.js       # Markdown editor
│   └── marked.min.js          # Markdown → HTML parser
├── uploads/                   # User-uploaded images (auto-created)
└── *.html                     # All pages (flat structure)
```

>  **Design Principle**: Frontend (HTML/JS) ↔ Backend (PHP API) — no PHP in HTML.

---

##  Local Development (XAMPP)

### Prerequisites
- [XAMPP](https://www.apachefriends.org) (Apache + MySQL)
- Browser with JavaScript enabled

### Setup
1. **Clone** this repo into `htdocs/`:
   ```bash
   git clone https://github.com/DewmiDurga
   cd myblog
   ```

2. **Create Database** (`blog_db`) in phpMyAdmin:
   ```sql
   CREATE DATABASE blog_db;
   USE blog_db;
   
   -- Users
   CREATE TABLE user (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       email VARCHAR(100) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL
   );
   
   -- Posts
   CREATE TABLE blogPost (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id INT NOT NULL,
       title VARCHAR(255) NOT NULL,
       content TEXT NOT NULL,
       image VARCHAR(255) NULL,
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
       updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
   );
   ```

3. **Start Apache & MySQL** in XAMPP Control Panel

4. **Visit**: `http://localhost/blog-app2/frontend/index.html`

---

##  Deployment (InfinityFree)

1. **Prepare Files**:
   - Remove `/blog-app2/` from all API paths (e.g., `/blog-app2/backend/...` → `/backend/...`)
   - Update `backend/config/db.php` with InfinityFree credentials

2. **Upload**:
   - Use **File Manager** or **FTP** to upload to `htdocs/`
   - ⚠️ **Do NOT upload `uploads/`** — let PHP create it

3. **Import Database** via phpMyAdmin

4. **Verify**: `https://yourname.epizy.com`

> 🔑 **cPanel**: `https://yourname.infinityfreeapp.com/cpanel`

---

##  Security

| Feature | Implementation |
|--------|----------------|
| **Passwords** | `password_hash()` + `password_verify()` |
| **SQL Injection** | PDO prepared statements |
| **XSS** | HTML sanitization (allowed tags only) |
| **CSRF** | Cookie-based sessions |
| **File Uploads** | Type/size validation, unique filenames |

---

##  Testing

| Action | Expected Result |
|-------|-----------------|
| Register → Login | Redirect to homepage + "Welcome, ..." |
| Create post (with image) | Post appears on homepage + in DB |
| Edit/Delete own post | Works |
| Edit/Delete others' post | ❌ Forbidden (403) |
| Logout → Back button | Redirects to login (no cached auth) |

---

## 📜 License

MIT License — see [LICENSE](LICENSE)

---

## 🙏 Acknowledgements

- [SimpleMDE](https://github.com/sparksuite/simplemde-markdown-editor)
- [Marked.js](https://github.com/markedjs/marked)
- [Font Awesome](https://fontawesome.com) (for icons)

---

> ✨ **This project proves you don’t need frameworks to build secure, modern web apps.**  


